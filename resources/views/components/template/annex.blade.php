<div class="">
    <h2><strong>Annexes</strong></h2>
    @foreach ($annexes as $annex)
        @if (Str::endsWith($annex->annex_file, ['.jpg', '.jpeg', '.png']))
            <table class="mt-5 page-break" style="border-collapse: collapse; margin-left:20pt" cellspacing="0">

                <tr style="height: 33pt">
                    <td class="column" style="width: 150pt;">
                        <p class="s2 column-head" style="font-size:20px;"><span style="font-weight:bold;">Annex:</span>
                            {{ $annex->title }}</p>
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
        @endif
    @endforeach
</div>
