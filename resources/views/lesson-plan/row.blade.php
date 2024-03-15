<tr class="view-lp" data-value="@{{ id }}" style="cursor: pointer;">
    <td>
        <div class="d-flex flex-column justify-content-center">
            <p class="text-m text-dark font-weight-bold mb-0">@{{ subject }}</p>
        </div>
    </td>
    <td>
        <div class="d-flex flex-column justify-content-center">
            <span class="text-dark text-m font-weight-bold">@{{ class }}</span>
        </div>
    </td>
    <td>
        <div class="d-flex flex-column justify-content-center px-2">
            <h6 class="mb-0 text-m">@{{ theme }}</h6>
        </div>
    </td>
    <td>
        <div class="d-flex flex-column justify-content-center">
            <p class="text-m text-dark font-weight-bold mb-0">@{{ topic }}</p>
        </div>
    </td>
    <td>
        <div class="d-flex flex-column justify-content-center">
            <span class="text-dark text-m font-weight-bold">@{{ learners_no }}</span>
        </div>
    </td>
    <td>
        <div class="d-flex flex-column justify-content-center">
            <p class="text-m text-dark font-weight-bold mb-0">@{{ duration }}'</p>
        </div>
    </td>
    <td>
        <div class="d-flex flex-column justify-content-center">
            <p class="text-m text-dark font-weight-bold mb-0">@{{ status }}</p>
        </div>
    </td>
    <td>
        <div class="d-flex flex-column justify-content-center">
            <span class="text-dark text-m font-weight-bold">@{{ visibility }}</span>
        </div>
    </td>
    <td>
        <div class="d-flex flex-column justify-content-center">
            <span class="text-dark text-m font-weight-bold">@{{ owner }}</span>
        </div>
    </td>
    <td>
        <div class="d-flex flex-column justify-content-center">
            <span class="text-dark text-m font-weight-bold">@{{ school }}</span>
        </div>
    </td>
    <td class="align-middle not-export-col">
        <a rel="tooltip" class="view-lp" data-value="@{{ id }}" style="cursor:pointer;">
            <i class="material-icons" style="font-size:25px;margin-right:20px;">visibility</i>
            <div class="ripple-container"></div>
        </a>
    </td>
</tr>
