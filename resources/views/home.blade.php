@extends('layouts.app')

@section('content')
    <form method="get" id="parsing-form" action="{{ route('start') }}" enctype="multipart/form-data">
        <div class="search-form mb-4">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label" for="site">Enter your URL:</label>
                        <input id="site" type="text" class="form-control" name="site" required autocomplete="site"
                               autofocus>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <button type="submit" class="btn btn-primary" id="submit-button">
                    Find broken links
                </button>
            </div>
        </div>
    </form>

    <h2>Checker history</h2>
    <div class="search-form mb-4">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-secondary table-bordered table-striped reports-datatable" style="width:100%">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Site</th>
                        <th>Time</th>
                        <th>Checked links, pcs</th>
                        <th>Broken links, pcs</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div id="result">
        <h2>Checker result</h2>
        <div class="loading">
            <div class="half-circle-spinner">
                <div class="circle circle-1"></div>
                <div class="circle circle-2"></div>
            </div>
        </div>
        <div id="result-table">
            @include('part.table')
        </div>
    </div>
@endsection
