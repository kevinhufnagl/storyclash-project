<div id="sidebar" class="active">
    <div class="sidebar__left">
        <div class="sidebar__icon-container js-toggle-sidebar" >
            <div class="sidebar__icon" style="background-image:url({{ secure_asset('svg/logo_nobg.svg') }})"></div>
        </div>
    </div>
    <div class="sidebar__content">
        <div class="sidebar__content--header">
            <div class="sidebar__content--header__arrow js-hide-sidebar">
                @svg('arrow_back_small')
            </div>
            <div class="sidebar__content--header__icon">
                @svg('bookmark')    
            </div>
            <h1 class="sidebar__content--header__title">
                Saved Reports
            </h1>
        </div>
        <div class="report-container js-reports active">
            <div class="report-container__header js-toggle-reports">
                <h1 class="report-container__title">My Reports</h1>
                <div class="report-container__toggle js-toggle-reports-icon">
                    @svg('arrow_down')
                </div>
            </div>
            <div class="report-container__content">
                <ul class="report-container__list js-report-list">
                    <?php /*
                    //Loading the reports via AJAX in app.js
                    @component('components.reportList', ['reports' => $reports])
                    @endcomponent
                    */ ?>
                </ul>
                <form name="addReportForm" id="addReportForm" method="post" action="javascript:void(0)" enctype="multipart/form-data">
                    <div class="flow-horizontal center-vertical">
                        <input type="hidden" name="defaultIcon" id="defaultIcon" value="trophy.svg" />
                        <input name='icon' id='icon' type='file' accept='image/*'/>
                        <label for='icon'>
                            <div id="icon-preview"></div>
                        </label>
                        <input name='title' id='title' type='text' placeholder="Report title" />
                    </div>
                    <div class="form-message"></div>
                </form>
                <div class="add-report-container js-add-report">
                    <div class="add-report-container__icon">
                        @svg('plus')
                    </div>
                    <div class="add-report-container__title">
                        Save Report
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>