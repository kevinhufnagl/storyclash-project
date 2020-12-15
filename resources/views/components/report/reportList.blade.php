@foreach($reports as $report)
    @component('components.report.reportItem', ['report' => $report])
    @endcomponent
@endforeach