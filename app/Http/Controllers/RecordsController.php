<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecordsController extends Controller
{
    public function GetMapRecord(Request $request, $MapId)
    {
        $StyleId = 1;

        if (isset($_GET['StyleId']) && is_numeric($_GET['StyleId']))
        {
            $StyleId = ($_GET['StyleId'] > 1) ? $_GET['StyleId'] : 1;
        }

        $mainRecords = DB::table('PlayerTiming')
                        ->join('PlayerTimingInsight', 'PlayerTiming.Id', '=', 'PlayerTimingInsight.PlayerTimingId')
                        ->select('PlayerTiming.Id', 'PlayerTiming.MapId', 'PlayerTiming.PlayerId', 'PlayerTiming.StyleId', 'PlayerTiming.Level', 'PlayerTiming.Type', 'PlayerTiming.Time', 'PlayerTiming.TimeInZone', 'PlayerTiming.Attempts', 'PlayerTiming.Status',
                                'PlayerTimingInsight.StartPositionX', 'PlayerTimingInsight.StartPositionY', 'PlayerTimingInsight.StartPositionZ',
                                'PlayerTimingInsight.EndPositionX', 'PlayerTimingInsight.EndPositionY', 'PlayerTimingInsight.EndPositionZ',
                                'PlayerTimingInsight.StartAngleX', 'PlayerTimingInsight.StartAngleY', 'PlayerTimingInsight.StartAngleZ',
                                'PlayerTimingInsight.EndAngleX', 'PlayerTimingInsight.EndAngleY', 'PlayerTimingInsight.EndAngleZ',
                                'PlayerTimingInsight.StartVelocityX', 'PlayerTimingInsight.StartVelocityY', 'PlayerTimingInsight.StartVelocityZ',
                                'PlayerTimingInsight.EndVelocityX', 'PlayerTimingInsight.EndVelocityY', 'PlayerTimingInsight.EndVelocityZ' )
                        ->where('PlayerTiming.MapId', $MapId)
                        ->where('PlayerTiming.StyleId', $StyleId)
                        ->groupBy('PlayerTiming.StyleId', 'PlayerTiming.Level')
                        ->orderBy('PlayerTiming.Time', 'asc')
                        ->get();

        $this->checkExists($mainRecords);

        $detailedRecords = [];

        foreach ($mainRecords as $mainRecord)
        {
            # Checkpoint/Stage Start
            $addRecords = null;

            if ($mainRecord->Type == 'Stage')
            {
                $addRecords = DB::table('PlayerTimingStage')
                        ->join('PlayerTimingStageInsight', 'PlayerTimingStage.Id', '=', 'PlayerTimingStageInsight.PlayerTimingStageId')
                        ->select('PlayerTimingStage.Id', 'PlayerTimingStage.Stage', 'PlayerTimingStage.Time', 'PlayerTimingStage.TimeInZone', 'PlayerTimingStage.Attempts',
                                'PlayerTimingStageInsight.StartPositionX', 'PlayerTimingStageInsight.StartPositionY', 'PlayerTimingStageInsight.StartPositionZ',
                                'PlayerTimingStageInsight.EndPositionX', 'PlayerTimingStageInsight.EndPositionY', 'PlayerTimingStageInsight.EndPositionZ',
                                'PlayerTimingStageInsight.StartAngleX', 'PlayerTimingStageInsight.StartAngleY', 'PlayerTimingStageInsight.StartAngleZ',
                                'PlayerTimingStageInsight.EndAngleX', 'PlayerTimingStageInsight.EndAngleY', 'PlayerTimingStageInsight.EndAngleZ',
                                'PlayerTimingStageInsight.StartVelocityX', 'PlayerTimingStageInsight.StartVelocityY', 'PlayerTimingStageInsight.StartVelocityZ',
                                'PlayerTimingStageInsight.EndVelocityX', 'PlayerTimingStageInsight.EndVelocityY', 'PlayerTimingStageInsight.EndVelocityZ' )
                        ->where('PlayerTimingStage.PlayerTimingId', $mainRecord->Id)
                        ->orderBy('Stage', 'asc')
                        ->get();
            }
            else if ($mainRecord->Type == 'Checkpoint')
            {
                $addRecords = DB::table('PlayerTimingCheckpoint')
                        ->join('PlayerTimingCheckpointInsight', 'PlayerTimingCheckpoint.Id', '=', 'PlayerTimingCheckpointInsight.PlayerTimingCheckpointId')
                        ->select('PlayerTimingCheckpoint.Id', 'PlayerTimingCheckpoint.Checkpoint', 'PlayerTimingCheckpoint.Time',
                                'PlayerTimingCheckpointInsight.PositionX', 'PlayerTimingCheckpointInsight.PositionY', 'PlayerTimingCheckpointInsight.PositionZ',
                                'PlayerTimingCheckpointInsight.AngleX', 'PlayerTimingCheckpointInsight.AngleY', 'PlayerTimingCheckpointInsight.AngleZ',
                                'PlayerTimingCheckpointInsight.VelocityX', 'PlayerTimingCheckpointInsight.VelocityY', 'PlayerTimingCheckpointInsight.VelocityZ')
                        ->where('PlayerTimingCheckpoint.PlayerTimingId', $mainRecord->Id)
                        ->orderBy('Checkpoint', 'asc')
                        ->get();
            }

            $this->checkExists($addRecords);

            $addRecords = (array)$addRecords;
            $mainRecord = (array)$mainRecord;

            array_push($mainRecord, $addRecords);
            # Checkpoint/Stage End

            array_push($detailedRecords, $mainRecord);
        }

        return response()->json($detailedRecords);
    }

    public function GetMapPlayerRecord(Request $request, $MapId, $PlayerId)
    {
        $StyleId = 1;

        if (isset($_GET['StyleId']) && is_numeric($_GET['StyleId']))
        {
            $StyleId = ($_GET['StyleId'] > 1) ? $_GET['StyleId'] : 1;
        }

        $mainRecords = DB::table('PlayerTiming')
                        ->join('PlayerTimingInsight', 'PlayerTiming.Id', '=', 'PlayerTimingInsight.PlayerTimingId')
                        ->select('PlayerTiming.Id', 'PlayerTiming.MapId', 'PlayerTiming.PlayerId', 'PlayerTiming.StyleId', 'PlayerTiming.Level', 'PlayerTiming.Type', 'PlayerTiming.Time', 'PlayerTiming.TimeInZone', 'PlayerTiming.Attempts', 'PlayerTiming.Status',
                                'PlayerTimingInsight.StartPositionX', 'PlayerTimingInsight.StartPositionY', 'PlayerTimingInsight.StartPositionZ',
                                'PlayerTimingInsight.EndPositionX', 'PlayerTimingInsight.EndPositionY', 'PlayerTimingInsight.EndPositionZ',
                                'PlayerTimingInsight.StartAngleX', 'PlayerTimingInsight.StartAngleY', 'PlayerTimingInsight.StartAngleZ',
                                'PlayerTimingInsight.EndAngleX', 'PlayerTimingInsight.EndAngleY', 'PlayerTimingInsight.EndAngleZ',
                                'PlayerTimingInsight.StartVelocityX', 'PlayerTimingInsight.StartVelocityY', 'PlayerTimingInsight.StartVelocityZ',
                                'PlayerTimingInsight.EndVelocityX', 'PlayerTimingInsight.EndVelocityY', 'PlayerTimingInsight.EndVelocityZ' )
                        ->where('PlayerTiming.MapId', $MapId)
                        ->where('PlayerTiming.PlayerId', $PlayerId)
                        ->where('PlayerTiming.StyleId', $StyleId)
                        ->groupBy('PlayerTiming.StyleId', 'PlayerTiming.Level')
                        ->orderBy('PlayerTiming.Time', 'asc')
                        ->get();

        $this->checkExists($mainRecords);

        $detailedRecords = [];

        foreach ($mainRecords as $mainRecord)
        {
            # Checkpoint/Stage Start
            $addRecords = null;

            if ($mainRecord->Type == 'Stage')
            {
                $addRecords = DB::table('PlayerTimingStage')
                        ->join('PlayerTimingStageInsight', 'PlayerTimingStage.Id', '=', 'PlayerTimingStageInsight.PlayerTimingStageId')
                        ->select('PlayerTimingStage.Id', 'PlayerTimingStage.Stage', 'PlayerTimingStage.Time', 'PlayerTimingStage.TimeInZone', 'PlayerTimingStage.Attempts',
                                'PlayerTimingStageInsight.StartPositionX', 'PlayerTimingStageInsight.StartPositionY', 'PlayerTimingStageInsight.StartPositionZ',
                                'PlayerTimingStageInsight.EndPositionX', 'PlayerTimingStageInsight.EndPositionY', 'PlayerTimingStageInsight.EndPositionZ',
                                'PlayerTimingStageInsight.StartAngleX', 'PlayerTimingStageInsight.StartAngleY', 'PlayerTimingStageInsight.StartAngleZ',
                                'PlayerTimingStageInsight.EndAngleX', 'PlayerTimingStageInsight.EndAngleY', 'PlayerTimingStageInsight.EndAngleZ',
                                'PlayerTimingStageInsight.StartVelocityX', 'PlayerTimingStageInsight.StartVelocityY', 'PlayerTimingStageInsight.StartVelocityZ',
                                'PlayerTimingStageInsight.EndVelocityX', 'PlayerTimingStageInsight.EndVelocityY', 'PlayerTimingStageInsight.EndVelocityZ' )
                        ->where('PlayerTimingStage.PlayerTimingId', $mainRecord->Id)
                        ->orderBy('Stage', 'asc')
                        ->get();
            }
            else if ($mainRecord->Type == 'Checkpoint')
            {
                $addRecords = DB::table('PlayerTimingCheckpoint')
                        ->join('PlayerTimingCheckpointInsight', 'PlayerTimingCheckpoint.Id', '=', 'PlayerTimingCheckpointInsight.PlayerTimingCheckpointId')
                        ->select('PlayerTimingCheckpoint.Id', 'PlayerTimingCheckpoint.Checkpoint', 'PlayerTimingCheckpoint.Time',
                                'PlayerTimingCheckpointInsight.PositionX', 'PlayerTimingCheckpointInsight.PositionY', 'PlayerTimingCheckpointInsight.PositionZ',
                                'PlayerTimingCheckpointInsight.AngleX', 'PlayerTimingCheckpointInsight.AngleY', 'PlayerTimingCheckpointInsight.AngleZ',
                                'PlayerTimingCheckpointInsight.VelocityX', 'PlayerTimingCheckpointInsight.VelocityY', 'PlayerTimingCheckpointInsight.VelocityZ')
                        ->where('PlayerTimingCheckpoint.PlayerTimingId', $mainRecord->Id)
                        ->orderBy('Checkpoint', 'asc')
                        ->get();
            }

            $this->checkExists($addRecords);

            $addRecords = (array)$addRecords;
            $mainRecord = (array)$mainRecord;

            array_push($mainRecord, $addRecords);
            # Checkpoint/Stage End

            array_push($detailedRecords, $mainRecord);
        }

        return response()->json($detailedRecords);
    }
}
