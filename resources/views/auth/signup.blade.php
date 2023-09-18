<style>
    .toggle-password {
        cursor: pointer;
        padding: 0px 10px;
        border-left: none;
        font-size: 18px;
        z-index: 1000;
    }

    .select2-container--default .select2-selection--single {
        padding: 4px;
        border: 1px solid #d2d6da !important;
    }

    .select2-container .select2-selection--single {
        height: 38px !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #7b809a !important;
        font-size: 0.875rem !important;
        font-weight: 400 !important;
    }
</style>
<x-layout bodyClass="bg-gray-200">
    <main class="main-content mt-0">
        <div class="page-header align-items-start min-vh-100">
            <span class="mask bg-gradient-dark opacity-1"></span>
            <div class="container mt-5">
                <center><img src="{{ asset('assets') }}/img/logos/actnow-logo.png" alt="ACT Now" class="m-3 mb-5" width="200"></center>
                <div class="row">
                    <div class="col-lg-4 col-md-8 col-12 mx-auto">
                        <div class="card z-index-0 fadeIn3 fadeInBottom">
                            <div class="card-body">
                                <h4 class="text-center">Sign Up</h4>
                                <form role="form" method="POST" class="text-start" id="signUpForm">
                                    @csrf
                                    @if (Session::has('status'))
                                    <div class="alert alert-success alert-dismissible text-white" role="alert">
                                        <span class="text-sm">{{ Session::get('status') }}</span>
                                        <button type="button" class="btn-close text-lg py-3 opacity-10"
                                            data-bs-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    @endif
                                    <div class="input-group input-group-outline mt-3">
                                        <label class="form-label">Name</label>
                                        <input type="text" class="form-control" name="name">
                                    </div>
                                    <p class='text-danger font-weight-bold inputerror' id="nameError"></p>

                                    <div class="input-group input-group-outline mt-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email">
                                    </div>
                                    <p class='text-danger font-weight-bold inputerror' id="emailError"></p>

                                    <div class="input-group input-group-outline mt-3">
                                        <label class="form-label">Phone (e.g. 0771234567)</label>
                                        <input type="text" class="form-control" name="phone">
                                    </div>
                                    <p class='text-danger font-weight-bold inputerror' id="phoneError"></p>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="input-group input-group-outline mt-3">
                                                <label class="form-label">Town</label>
                                                <input type="text" class="form-control" name="town">
                                            </div>
                                            <p class='text-danger font-weight-bold inputerror' id="townError"></p>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-group input-group-outline mt-3">
                                                <select id="districts" class="form-select p-2" name="district" aria-label="">
                                                    <option value="" selected>Select District</option>
                                                    <option value="Abim">Abim</option>
                                                    <option value="Adjumani">Adjumani</option>
                                                    <option value="Agago">Agago</option>
                                                    <option value="Alebtong">Alebtong</option>
                                                    <option value="Amolatar">Amolatar</option>
                                                    <option value="Amudat">Amudat</option>
                                                    <option value="Amuria">Amuria</option>
                                                    <option value="Amuru">Amuru</option>
                                                    <option value="Apac">Apac</option>
                                                    <option value="Arua">Arua</option>
                                                    <option value="Budaka">Budaka</option>
                                                    <option value="Bududa">Bududa</option>
                                                    <option value="Bugiri">Bugiri</option>
                                                    <option value="Buhweju">Buhweju</option>
                                                    <option value="Buikwe">Buikwe</option>
                                                    <option value="Bukedea">Bukedea</option>
                                                    <option value="Bukomansimbi">Bukomansimbi</option>
                                                    <option value="Bukwo">Bukwo</option>
                                                    <option value="Bulambuli">Bulambuli</option>
                                                    <option value="Buliisa">Buliisa</option>
                                                    <option value="Bundibugyo">Bundibugyo</option>
                                                    <option value="Bunyangabu">Bunyangabu</option>
                                                    <option value="Bushenyi">Bushenyi</option>
                                                    <option value="Busia">Busia</option>
                                                    <option value="Butaleja">Butaleja</option>
                                                    <option value="Butambala">Butambala</option>
                                                    <option value="Butebo">Butebo</option>
                                                    <option value="Buvuma">Buvuma</option>
                                                    <option value="Buyende">Buyende</option>
                                                    <option value="Dokolo">Dokolo</option>
                                                    <option value="Gomba">Gomba</option>
                                                    <option value="Gulu">Gulu</option>
                                                    <option value="Hoima">Hoima</option>
                                                    <option value="Ibanda">Ibanda</option>
                                                    <option value="Iganga">Iganga</option>
                                                    <option value="Isingiro">Isingiro</option>
                                                    <option value="Jinja">Jinja</option>
                                                    <option value="Kaabong">Kaabong</option>
                                                    <option value="Kabale">Kabale</option>
                                                    <option value="Kabarole">Kabarole</option>
                                                    <option value="Kaberamaido">Kaberamaido</option>
                                                    <option value="Kagadi">Kagadi</option>
                                                    <option value="Kakumiro">Kakumiro</option>
                                                    <option value="Kalangala">Kalangala</option>
                                                    <option value="Kaliro">Kaliro</option>
                                                    <option value="Kalungu">Kalungu</option>
                                                    <option value="Kampala">Kampala</option>
                                                    <option value="Kamuli">Kamuli</option>
                                                    <option value="Kamwenge">Kamwenge</option>
                                                    <option value="Kanungu">Kanungu</option>
                                                    <option value="Kapchorwa">Kapchorwa</option>
                                                    <option value="Kasese">Kasese</option>
                                                    <option value="Katakwi">Katakwi</option>
                                                    <option value="Kayunga">Kayunga</option>
                                                    <option value="Kibaale">Kibaale</option>
                                                    <option value="Kiboga">Kiboga</option>
                                                    <option value="Kibuku">Kibuku</option>
                                                    <option value="Kiruhura">Kiruhura</option>
                                                    <option value="Kiryandongo">Kiryandongo</option>
                                                    <option value="Kisoro">Kisoro</option>
                                                    <option value="Kitgum">Kitgum</option>
                                                    <option value="Koboko">Koboko</option>
                                                    <option value="Kole">Kole</option>
                                                    <option value="Kotido">Kotido</option>
                                                    <option value="Kumi">Kumi</option>
                                                    <option value="Kween">Kween</option>
                                                    <option value="Kyankwanzi">Kyankwanzi</option>
                                                    <option value="Kyegegwa">Kyegegwa</option>
                                                    <option value="Kyenjojo">Kyenjojo</option>
                                                    <option value="Kyotera">Kyotera</option>
                                                    <option value="Lamwo">Lamwo</option>
                                                    <option value="Lira">Lira</option>
                                                    <option value="Luuka">Luuka</option>
                                                    <option value="Luweero">Luweero</option>
                                                    <option value="Lwengo">Lwengo</option>
                                                    <option value="Lyantonde">Lyantonde</option>
                                                    <option value="Manafwa">Manafwa</option>
                                                    <option value="Maracha">Maracha</option>
                                                    <option value="Masaka">Masaka</option>
                                                    <option value="Masindi">Masindi</option>
                                                    <option value="Mayuge">Mayuge</option>
                                                    <option value="Mbale">Mbale</option>
                                                    <option value="Mbarara">Mbarara</option>
                                                    <option value="Mitooma">Mitooma</option>
                                                    <option value="Mityana">Mityana</option>
                                                    <option value="Moroto">Moroto</option>
                                                    <option value="Moyo">Moyo</option>
                                                    <option value="Mpigi">Mpigi</option>
                                                    <option value="Mubende">Mubende</option>
                                                    <option value="Mukono">Mukono</option>
                                                    <option value="Nakapiripirit">Nakapiripirit</option>
                                                    <option value="Nakaseke">Nakaseke</option>
                                                    <option value="Nakasongola">Nakasongola</option>
                                                    <option value="Namayingo">Namayingo</option>
                                                    <option value="Namisindwa">Namisindwa</option>
                                                    <option value="Namutumba">Namutumba</option>
                                                    <option value="Napak">Napak</option>
                                                    <option value="Nebbi">Nebbi</option>
                                                    <option value="Ngora">Ngora</option>
                                                    <option value="Ntoroko">Ntoroko</option>
                                                    <option value="Ntungamo">Ntungamo</option>
                                                    <option value="Nwoya">Nwoya</option>
                                                    <option value="Obongi">Obongi</option>
                                                    <option value="Omoro">Omoro</option>
                                                    <option value="Otuke">Otuke</option>
                                                    <option value="Oyam">Oyam</option>
                                                    <option value="Pader">Pader</option>
                                                    <option value="Pakwach">Pakwach</option>
                                                    <option value="Pallisa">Pallisa</option>
                                                    <option value="Rakai">Rakai</option>
                                                    <option value="Rubanda">Rubanda</option>
                                                    <option value="Rubirizi">Rubirizi</option>
                                                    <option value="Rukiga">Rukiga</option>
                                                    <option value="Rukungiri">Rukungiri</option>
                                                    <option value="Sembabule">Sembabule</option>
                                                    <option value="Serere">Serere</option>
                                                    <option value="Sheema">Sheema</option>
                                                    <option value="Sironko">Sironko</option>
                                                    <option value="Soroti">Soroti</option>
                                                    <option value="Tororo">Tororo</option>
                                                    <option value="Wakiso">Wakiso</option>
                                                    <option value="Yumbe">Yumbe</option>
                                                    <option value="Zombo">Zombo</option>
                                                </select>
                                            </div>
                                            <p class='text-danger font-weight-bold inputerror' id="districtError"></p>
                                        </div>
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">School</label>
                                        <select id="school-records" class="form-select p-2" name="school" aria-label="">
                                            <option value="" selected>Select School</option>
                                            @foreach($schools as $school)
                                            <option value="{!! $school->id !!}">{!! $school->name !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <p class='text-danger font-weight-bold inputerror' id="schoolError"></p>

                                    {{-- <div class="mb-3 col-md-6">
                                        <label class="form-label">Subject</label>
                                        <select id="subject-records" class="form-select p-2" name="subject_1" aria-label="">
                                            <option value="" selected>Select Subject</option>
                                            @foreach($subjects as $subject)
                                            <option value="{!! $subject->id !!}">{!! $subject->name !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <p class='text-danger font-weight-bold inputerror' id="subject_1Error"></p>

                                    <div id="addSubjects"></div> --}}

                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Subject 1</label>
                                        <select id="subject-records-1" class="form-select p-2 subject-records" name="subject_1" aria-label="">
                                            <option value="" selected>Select Subject</option>
                                            @foreach($subjects as $subject)
                                            <option value="{!! $subject->id !!}">{!! $subject->name !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <p class='text-danger font-weight-bold inputerror' id="subject_1Error"></p>

                                    <div id="addSubjects"></div>

                                    <button type="button" id="addSubjectButton" class="btn btn-primary mt-2">Add Subject</button>

                                    <div class="input-group input-group-outline mt-3">
                                        <label class="form-label">Password</label>
                                        <input type="password" class="form-control" name="password" id="password">
                                        <span class="input-group-text">
                                            <i class="toggle-password fa fa-eye"></i>
                                        </span>
                                    </div>
                                    <p class='text-danger font-weight-bold inputerror' id="passwordError"></p>

                                    <input type="hidden" name="role" value="Teacher">

                                    <div class="text-center">
                                        <button type="submit" class="btn bg-gradient-info w-100 my-4 mb-2 btn-submit">Sign Up <span id="loader"></span></button>
                                    </div>

                                    <div class="text-center">
                                        <p class="text-sm text-center">
                                            - OR -
                                        </p>
                                        <a href="{{ route('login') }}" class="btn bg-gradient-success w-100" >Sign In</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <x-footer></x-footer>
        </div>
    </main>
</x-layout>

<script src="{{ asset('assets') }}/js/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#school-records').select2();
        $('#subject-records-1').select2();
        $('#districts').select2();
    });

    $(function() {

        var text_val = $(".input-group input").val();
        if (text_val === "") {
        $(".input-group").removeClass('is-filled');
        } else {
        $(".input-group").addClass('is-filled');
        }
    });

    $(".toggle-password").click(function () {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var passwordField = $("#password");
        var passwordFieldType = passwordField.attr("type");
        if (passwordFieldType === "password") {
            passwordField.attr("type", "text");
        } else {
            passwordField.attr("type", "password");
        }
    });

    $(function(){
        $('.btn-submit').on('click', function (e) {
            e.preventDefault();

            let formData = $('#signUpForm').serializeArray();
            $(".inputerror").text("");
            $("#signUpForm input").removeClass("is-invalid");
            $("#signUpForm select").removeClass("is-invalid");
            $("#signUpForm textarea").removeClass("is-invalid");

            $("#loader").prepend('<i class="fa fa-spinner fa-spin"></i>');
            $(".btn-submit").attr("disabled", 'disabled');

            $.ajax({
                method: "POST",
                headers: {
                    Accept: "application/json"
                },
                url: "{{ route('signup') }}",
                data: formData,
                success: (response) => {
                    $(".fa-spinner").remove();
                    $(".btn-submit").prop("disabled", false);
                    let url = '{{route("signup.success")}}';
                    window.location.assign(url);
                },
                error: (response) => {
                    $(".fa-spinner").remove();
                    $(".btn-submit").prop("disabled", false);

                    if(response.status === 422) {
                        let errors = response.responseJSON.errors;
                        Object.keys(errors).forEach(function (key) {
                            $("[name='" + key + "']").addClass("is-invalid");
                            $("#" + key + "Error").text(errors[key][0]);
                        });
                    }
                }
            })
        });
    })
</script>

<script>
    $(document).ready(function() {
        var maxSubjects = 3; // Maximum number of subjects
        var subjectCount = 1; // Initial subject count

        $("#addSubjectButton").click(function() {
            if (subjectCount < maxSubjects) {
                subjectCount++;

                var newSubjectSelect = `
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Subject `+subjectCount+`</label>
                        <select id="subject-records-`+subjectCount+`" class="form-select p-2" name="subject_`+subjectCount+`" aria-label="">
                            <option value="" selected>Select Subject</option>
                            @foreach($subjects as $subject)
                            <option value="{!! $subject->id !!}">{!! $subject->name !!}</option>
                            @endforeach
                        </select>
                        <p class='text-danger font-weight-bold inputerror' id="subject_`+subjectCount+`Error"></p>
                    </div>
                `;

                // Create a remove button for the new subject field
                var removeButton = $("<button>").text("Remove Subject").addClass("btn btn-danger mt-2");

                removeButton.click(function() {
                    $(this).prev().remove(); // Remove the select element
                    $(this).remove(); // Remove the remove button
                    subjectCount--;
                });

                // Append the new subject select and remove button to #addSubjects
                $("#addSubjects").append(newSubjectSelect).append(removeButton);
            }
        });
    });
</script>
