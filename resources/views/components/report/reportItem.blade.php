<li data-id="{{$report->id}}" class="report-container__list--item">
    <div class="report__icon" style="background-image:url({{secure_url('/uploads/reportIcons/'.$report->icon)}})"></div>
    <h1 class="report__title js-report-title">{{$report->title}}</h1>
    <div class="report__options js-report-options">
        @svg('context')
    </div>
    <div class="report__menu js-report-menu">
        <div data-id="{{$report->id}}" class="report__menu--item report__rename js-rename-report">
            <div class="report__menu--icon" style="background-image:url({{secure_asset('/svg/edit.svg')}})"></div>
            <div class="report__menu--text">Rename</div>
        </div>
        <div data-id="{{$report->id}}"  class="report__menu--item report__delete js-delete-report">
            <div class="report__menu--icon" style="background-image:url({{secure_asset('/svg/trash.svg')}})"></div>
            <div class="report__menu--text">Delete</div>
        </div>
    </div>
    <div class="overlay"></div>
</li>