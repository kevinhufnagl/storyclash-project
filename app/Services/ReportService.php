<?php

namespace App\Services;

use App\Repositories\ReportRepository;
use Exception;
use InvalidArgumentException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ReportService {

    protected $reportRepository;

    /**
     * ReportService Constructor
     *
     * @param  mixed $reportRepository
     * @return void
     */
    public function __construct(ReportRepository $reportRepository) {
        $this->reportRepository = $reportRepository;
    }
    
    /**
     * Validate data from Controller and hand off to repository for saving.
     *
     * @param  mixed $data
     * @return Report
     */
    public function save($data) {
        $request = app(\Illuminate\Http\Request::class);

        $validator = Validator::make($data, [
            'title' => 'required|max:255',
            'icon' => 'image|max:2056',
            'defaultIcon' => 'required'
        ]);

        if($validator->fails()) {
           throw new InvalidArgumentException($validator->errors()->first());
        }

        //Check if icon has been uploaded, otherwise use default icon
        if(array_key_exists('icon', $data)) {
            $iconFile = $request->file('icon');
            $iconPath = Storage::disk('report_uploads')->put('', $iconFile);
            $data['icon'] = $iconPath;
        }
        else {
            $data['icon'] = $data['defaultIcon'];
        }


        $result = $this->reportRepository->save($data);
        return $result;
    }
        
    /**
     * Updates a report using ReportRepository
     *
     * @param  mixed $data
     * @param  mixed $id
     * @return Report
     */
    public function update($data, $id) {
        $validator = Validator::make($data, [
            'title' => 'min:1|max:255',
        ]);

        if($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        /**
         * Using transactions here since it may be possible that we update multiple dependent objects as well in the future.
         * This way rollback is easier
         */
        DB::beginTransaction();

        try {
            $report = $this->reportRepository->update($data, $id);
        } catch(Exception $e) {
            DB::rollBack();
            throw new InvalidArgumentException($e->getMessage());
        }

        DB::commit();

        return $report;
    }
    
    /**
     * Deletes a report using ReportRepository
     *
     * @param  mixed $id
     * @return Report
     */
    public function delete($id) {
        /**
         * Using transactions here since it may be possible that we delete multiple dependent objects as well in the future.
         * This way rollback is easier
         */
        DB::beginTransaction();
        try {
            $report = $this->reportRepository->delete($id);
        } catch(Exception $e) {
            DB::rollBack();
            throw new InvalidArgumentException($e->getMessage());
        }
        DB::commit();
        return $report;
    }

    public function getAll() {
        return $this->reportRepository->getAll();
    }

}