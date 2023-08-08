@extends('layouts.app')

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="post" action="{{ route('process.form') }}" id="form">
        @csrf
        <div class="form-group">
            <label for="company_symbol">Company Symbol:</label>
            <select class="form-control" id="company_symbol" name="company_symbol" required>
                <option value="" disabled selected>Select a Company</option>
                @foreach ($companySymbols as $symbol => $name)
                    <option value="{{ $symbol }}">{{ $symbol }} - {{ $name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="start_date">Start Date:</label>
            <input type="text" class="form-control" id="start_date" name="start_date" required>
        </div>

        <div class="form-group">
            <label for="end_date">End Date:</label>
            <input type="text" class="form-control" id="end_date" name="end_date" required>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
            <span id="email-error" class="text-danger"></span>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

    <script>
        $(function() {
            $("#start_date").datepicker({
                dateFormat: "yy-mm-dd",
                maxDate: new Date(), // Prevent dates in the future
                onSelect: function(selectedDate) {
                    $("#end_date").datepicker("option", "minDate", selectedDate);
                }
            });

            $("#end_date").datepicker({
                dateFormat: "yy-mm-dd",
                maxDate: new Date(), // Prevent dates in the future
                onSelect: function(selectedDate) {
                    $("#start_date").datepicker("option", "maxDate", selectedDate);
                }
            });

            $("#form").submit(function(e) {
                var startDate = $("#start_date").val();
                var endDate = $("#end_date").val();
                
                if (new Date(startDate) > new Date(endDate)) {
                    e.preventDefault();
                    alert("End date must be after start date.");
                }

                var email = $("#email").val();
                if (!isValidEmail(email)) {
                    e.preventDefault();
                    $("#email-error").text("Please enter a valid email address.");
                }
            });

            function isValidEmail(email) {
                // Basic email validation regex
                var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
                return emailPattern.test(email);
            }
        });
    </script>
@endsection