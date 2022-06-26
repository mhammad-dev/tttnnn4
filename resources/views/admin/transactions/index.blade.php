@extends('admin.layout.master')
@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Transactions</li>
            <li class="breadcrumb-item active" aria-current="page">Import Transactions</li>
        </ol>
    </nav>

    @if ( $message = Session::get('errors'))
    <div class="alert alert-danger">
      <p>{{$message}}</p>
    </div>
    @elseif($message = Session::get('success'))
    <div class="alert alert-success">
       <p>{{$message}}</p>
    </div>
    @endif
    
    <div class="row card py-4 px-3">
        <div class="col-md-12">
            <form action="{{ route('import_parse') }}" method="POST" class="mb-4" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="csv_file">CSV file to Import</label>
                    <input id="csv_file" class="form-control" type="file" name="csv_file" required />
                </div>

                <div class="form-group">
                    <label for="header">File Contains Header row? </label>
                    <input id="header" class="ml-2 form-check-input" type="checkbox" name="header" checked />
                </div>

                <button type="submit" class="btn btn-primary">
                    {{ __('Submit') }}
                </button>
            </form>

            {{-- <div class="col-md-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th>First name</th>
                            <th>Last name</th>
                            <th>Email</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($contacts as $contact)
                            <tr class="bg-white">
                                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                    {{ $contact->first_name }}
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                    {{ $contact->last_name }}
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                    {{ $contact->email }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="float-right">
                 {{ $contacts->links() }}
            </div> --}}
           

        </div>
    </div>

@endsection
