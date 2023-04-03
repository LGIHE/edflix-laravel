@foreach ($annexes as $annex)
    <div class="row align-items-start">
        <div class="col col-md-4">
            <img class="logo" src="{{ asset('assets') }}/img/logos/edflix-logo.png" width="250" height="75"
                alt="EDFLIX">
        </div>
        {{-- <div class="col col-md-4">
            <div class="row align-items-start">
                <div class="col">
                    <strong>School: </strong>{{ $school->name }}
                </div>
            </div>
            <div class="row align-items-start">
                <div class="col">
                    <strong>Class: </strong>{{ $lesson->class }}
                </div>
            </div>
            <div class="row align-items-start">
                <div class="col">
                    <strong>Theme: </strong>{{ $lesson->theme }}
                </div>
            </div>
            <div class="row align-items-start">
                <div class="col">
                    <strong>Number of learners: </strong>{{ $lesson->learners_no }}
                </div>
            </div>
        </div>
        <div class="col col-md-4">
            <div class="row align-items-start">
                <div class="col">
                    <strong>Teacher: </strong>{{ $owner->name }}
                </div>
            </div>
            <div class="row align-items-start">
                <div class="col">
                    <strong>Subject: </strong>{{ $subject->name }}
                </div>
            </div>
            <div class="row align-items-start">
                <div class="col">
                    <strong>Topic: </strong>{{ $lesson->topic }}
                </div>
            </div>
            <div class="row align-items-start">
                <div class="col">
                    <strong>Duration:
                    </strong>{{ Carbon\CarbonInterval::minutes($duration)->cascade()->forHumans() ?? '' }}
                </div>
            </div>
        </div> --}}
    </div>

    <table class="mt-5" style="border-collapse: collapse; margin-left:20pt" cellspacing="0">

        <tr style="height: 33pt">
            <td class="column" style="width: 150pt;">
                <p class="s2 column-head"><span style="font-weight:bold;">Annex:</span> {{ $annex->title }}</p>
            </td>
        </tr>
        <tr style="height: 33pt">
            <td class="column" style="width: 150pt;">
                <img src="{{ url('/annex/' . $annex->annex_file) }}" alt="{{ $annex->title }}" width="1000"
                    height="600">
            </td>
        </tr>

    </table>
    <br>
@endforeach
