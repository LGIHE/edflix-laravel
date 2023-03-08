<x-layout bodyClass="g-sidenav-show bg-gray-200">

    <x-navbars.sidebar activePage="lesson-plans"></x-navbars.sidebar>
    <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100 pb-5">
        <!-- Navbar -->
        <x-navbars.topbar titlePage='Lesson Plan'></x-navbars.topbar>
        <!-- End Navbar -->
        <div class="container-fluid px-2 px-md-4 mt-5">
            <div class="card card-body mx-3 mx-md-4 ">
                <div class="card card-plain h-100">
                    <div class="card-body p-3">
                        <div class=" me-3 my-3 text-end">
                            <a class="btn bg-gradient-info mb-0" href="{{ asset('assets') }}/download/edflix_lesson_plan.xlsx">
                                <i class="material-icons text-sm">download</i>&nbsp;&nbsp;Download Example LP
                            </a>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane fade active show">
                                <div class="card-header pb-0 p-3">
                                    <div class="row">
                                        <div class="col-md-8 d-flex align-items-center">
                                            <h4 class="mb-3">Upload Lesson Plan</h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8 d-flex align-items-center">
                                            <h6 class="mb-3"><u>Instructions</u> <span class="text-primary">*</span></h6>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8 d-flex">
                                            <ol>
                                                <li>First, download the upload example file using the blue button above.</li>
                                                <li>Edit the file on your computer /tablet /phone and save it.</li>
                                                <li>Upload the file in the upload section below:
                                                    <ul>
                                                        <li>Click on the choose file, and select the file you saved.</li>
                                                        <li>Then click on the upload button.</li>
                                                    </ul>
                                                </li>
                                            </ol>
                                        </div>
                                        <div class="card text-center">
                                            <div class="card-header"><h5>Upload Section</h5></div>
                                            <div class="card-body">
                                                <p class="card-text mb-3"><strong>Select File to Upload</strong> - <small class="text-muted">{{__('Please upload only Excel (.xlsx or .xls) files')}}</small></p>
                                                <form action="{{ route('upload.lesson.plan') }}" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="file" id="lpFile" name="lpfile" accept=".xls,.xlsx">
                                                    @error('lpfile')
                                                        <p class='text-danger inputerror font-weight-bold'>{{ $message }} </p>
                                                    @enderror
                                                    <button type="submit" class="btn btn-success mt-4">Upload Lesson Plan</button>
                                                </form>
                                                <pre id="jsonData"></pre>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>

<script>

$(function () {

    // $('.btn-submit').on('click', function (e) {
    //     e.preventDefault();

    //     let formData = $('#uploadLessonPlan').serializeArray();
    //     $(".inputerror").text("");
    //     $("#uploadLessonPlan input").removeClass("is-invalid");

    //     $("#loader").prepend('<i class="fa fa-spinner fa-spin"></i>');
    //     $(".btn-submit").attr("disabled", 'disabled');

    //     $.ajax({
    //         method: "POST",
    //         headers: {
    //             Accept: "application/json"
    //         },
    //         url: "{{ route('upload.lesson.plan') }}",
    //         data: formData,
    //         success: (response) => {
    //             $(".fa-spinner").remove();
    //             $(".btn-submit").prop("disabled", false);
    //             url = url.replace(':id', response.id);
    //             window.location.assign(url);
    //         },
    //         error: (response) => {
    //             $(".fa-spinner").remove();
    //             $(".btn-submit").prop("disabled", false);

    //             if(response.status === 422) {
    //                 let errors = response.responseJSON.errors;
    //                 Object.keys(errors).forEach(function (key) {
    //                     $("[name='" + key + "']").addClass("is-invalid");
    //                     $("#" + key + "Error").text(errors[key][0]);
    //                 });
    //             } else {
    //                 window.location.reload();
    //             }
    //         }
    //     })
    // });
})
</script>

<script>
    var selectedFile;
    document.getElementById("lpFile").addEventListener("change", function(event) {
        selectedFile = event.target.files[0];
    });

    document.getElementById("uploadLP").addEventListener("click", function() {
        if (selectedFile) {
          var fileReader = new FileReader();
          fileReader.onload = function(event) {
            var data = event.target.result;
            var workbook = XLSX.read(data, {type: "binary"});
            let result = [];

            workbook.SheetNames.forEach(sheet => {
                let rowObject = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheet]);

                result.push(rowObject[0]);

                let jsonObject = JSON.stringify(result);

                if(sheet == 'Sheet2'){
                    console.log(result);

                    $.ajax({
                        method: "POST",
                        headers: {
                            Accept: "application/json",
                            'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
                        },
                        url: "{{ route('upload.lesson.plan') }}",
                        data: result,
                        success: (response) => {
                            // $(".fa-spinner").remove();
                            // $(".btn-submit").prop("disabled", false);
                            // url = url.replace(':id', response.id);
                            // window.location.assign(url);
                            console.log(response);
                        },
                        error: (response) => {
                            // $(".fa-spinner").remove();
                            // $(".btn-submit").prop("disabled", false);

                            // if(response.status === 422) {
                            //     let errors = response.responseJSON.errors;
                            //     Object.keys(errors).forEach(function (key) {
                            //         $("[name='" + key + "']").addClass("is-invalid");
                            //         $("#" + key + "Error").text(errors[key][0]);
                            //     });
                            // } else {
                            //     window.location.reload();
                            // }
                            console.log(response);
                        }
                    });
                }
            });
          };
          fileReader.readAsBinaryString(selectedFile);
        }
      });
  </script>
