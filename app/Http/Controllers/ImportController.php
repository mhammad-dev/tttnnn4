<?php

namespace App\Http\Controllers;

use App\Models\CsvData;
use App\Models\TempTransaction;
use Illuminate\Http\Request;
use App\Imports\ContactsImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\CsvImportRequest;
use Maatwebsite\Excel\HeadingRowImport;
use Exception;

class ImportController extends Controller
{
    public function parseImport(CsvImportRequest $request)
    {
        if ($request->has('header')) {
            $headings = (new HeadingRowImport)->toArray($request->file('csv_file'));
            $data = Excel::toArray(new ContactsImport, $request->file('csv_file'))[0];
        } else {
            $data = array_map('str_getcsv', file($request->file('csv_file')->getRealPath()));
        }

        if (count($data) > 0) {
            $csv_data = array_slice($data, 0, 2);

            $csv_data_file = CsvData::create([
                'csv_filename' => $request->file('csv_file')->getClientOriginalName(),
                'csv_header' => $request->has('header'),
                'csv_data' => json_encode($data)
            ]);
        } else {
            return redirect()->back();
        }

        return view('admin.import_fields', [
            'headings' => $headings ?? null,
            'csv_data' => $csv_data,
            'csv_data_file' => $csv_data_file
        ]);
    }

    public function processImport(Request $request)
    {
        $data = CsvData::find($request->csv_data_file_id);
        $csv_data = json_decode($data->csv_data, true);
        $count = count($csv_data);
        try
        {
            foreach ($csv_data as $row) {
                $transaction = new TempTransaction();
                foreach (config('app.db_fields_transaction') as $index => $field) {
                    if ($data->csv_header) {
                        $transaction->$field = $row[$request->fields[$field]];
                    } else {
                        $transaction->$field = $row[$request->fields[$index]];
                    }
                }
                $transaction->save();
            }   
        }
        catch(Exception $e){
            $error= $e->errorInfo[2];
            return redirect('admin/transactions')->with('errors', $error);
        }


        // foreach ($csv_data as $row) {
        //     $transaction = new TempTransaction();
        //     foreach (config('app.db_fields_transaction') as $index => $field) {
        //         if ($data->csv_header) {
        //             $transaction->$field = $row[$request->fields[$field]];
        //         } else {
        //             $transaction->$field = $row[$request->fields[$index]];
        //         }
        //     }
        //     $transaction->save();
        // }
        $message = "Total " . $count . " rows found.";
        return redirect()->route('admin.transactions.confirmation')->with('success', $message);
    }
}