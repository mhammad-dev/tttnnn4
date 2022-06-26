@extends('admin.layout.master')
@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Transactions</li>
            <li class="breadcrumb-item">Import Transactions</li>
            <li class="breadcrumb-item active" aria-current="page">Data Mapping</li>
        </ol>
    </nav>
    <div class="row card py-4 px-3" >
        <div class="col-md-12 transactions-card-respo" >
            
                    <form action="{{ route('import_process') }}" method="POST">
                        @csrf

                        <input type="hidden" class="form-control" name="csv_data_file_id" value="{{ $csv_data_file->id }}"/>

                        <table class="table">
                            @if (isset($headings))
                                <thead class="">
                                <tr>
                                    @foreach ($headings[0][0] as $csv_header_field)
                                        {{--                                            @dd($headings)--}}
                                        <th style="min-width:150px">
                                            {{ $csv_header_field }}
                                        </th>
                                    @endforeach
                                </tr>
                                </thead>
                            @endif

                            <tbody>
                            @foreach($csv_data as $row)
                                <tr class="bg-white">
                                    @foreach ($row as $key => $value)
                                        <td style="min-width:150px">
                                            {{ $value }}
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach

                            <tr>
                                @foreach ($csv_data[0] as $key => $value)
                                    <td style="min-width:150px">
                                        <select name="fields[{{ $key }}]">
                                            @foreach (config('app.db_fields_transaction') as $db_field)
                                                <option value="{{ (\Request::has('header')) ? $db_field : $loop->index }}"
                                                        @if ($key === $db_field) selected @endif>{{ $db_field }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                @endforeach
                            </tr>
                            </tbody>
                        </table>

                        <button class="btn btn-primary mb-5 ml-3">
                            {{ __('Submit') }}
                        </button>
                    </form>
        </div>
    </div>

    
@endsection
