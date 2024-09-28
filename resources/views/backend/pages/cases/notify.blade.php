<form action="{{ route('admin.case.send.notify.submit',$case->id) }}" method="POST">
    @csrf
    <div class="container">
        <!-- Application Ref. Number -->
        <p><a href="{{ route('home.caseDetail',$case->id) }}" class="btn btn-sm btn-success">{{ route('home.caseDetail',$case->id) }}</a></p>
        <!-- Submit Button -->
        <div class="form-group text-center mt-4">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
</form>
