<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecordsController extends Controller
{
    public function GetMapRecord(Request $request, $MapId)
    {
        /*

            Select fatest main/bonus run per map
            get the player id
            select the other runs like checkpoints/stages
        */
        $mainRecords = DB::table('PlayerTiming')
                        ->join('PlayerTimingInsight', 'PlayerTiming.Id', '=', 'PlayerTimingInsight.PlayerTimingId')
                        ->select('PlayerTiming.Id', 'PlayerTiming.MapId', 'PlayerTiming.PlayerId', 'PlayerTiming.StyleId', 'PlayerTiming.Level', 'PlayerTiming.Time', 'PlayerTiming.TimeInZone', 'PlayerTiming.Attempts', 'PlayerTiming.Status',
                                'PlayerTimingInsight.StartPositionX', 'PlayerTimingInsight.StartPositionY', 'PlayerTimingInsight.StartPositionZ',
                                'PlayerTimingInsight.EndPositionX', 'PlayerTimingInsight.EndPositionY', 'PlayerTimingInsight.EndPositionZ',
                                'PlayerTimingInsight.StartAngleX', 'PlayerTimingInsight.StartAngleY', 'PlayerTimingInsight.StartAngleZ',
                                'PlayerTimingInsight.EndAngleX', 'PlayerTimingInsight.EndAngleY', 'PlayerTimingInsight.EndAngleZ',
                                'PlayerTimingInsight.StartVelocityX', 'PlayerTimingInsight.StartVelocityY', 'PlayerTimingInsight.StartVelocityZ',
                                'PlayerTimingInsight.EndVelocityX', 'PlayerTimingInsight.EndVelocityY', 'PlayerTimingInsight.EndVelocityZ' )
                        ->where('PlayerTiming.MapId', $MapId)
                        ->where('PlayerTiming.StyleId', 9)
                        ->groupBy('PlayerTiming.StyleId', 'PlayerTiming.Level')
                        ->orderBy('PlayerTiming.Time', 'asc')
                        ->get();

        $this->checkExists($mainRecords);

        $detailedRecords = [];

        foreach ($mainRecords as $mainRecord)
        {
            # Checkpoint/Stage Start
            $type = $mainRecord->MapId % 2 == 0 ? "Stage" : "Checkpoint"; // TODO: This is for testing, we'll remove it when we're ready
            $stageRecords = null;

            if ($type == 'Stage')
            {
                $stageRecords = DB::table('PlayerTimingStages')
                        ->join('PlayerTimingStageInsight', 'PlayerTimingStages.Id', '=', 'PlayerTimingStageInsight.PlayerTimingStageId')
                        ->select('PlayerTimingStages.Id', 'PlayerTimingStages.MapId', 'PlayerTimingStages.PlayerId', 'PlayerTimingStages.StyleId', 'PlayerTimingStages.Level', 'PlayerTimingStages.Stage', 'PlayerTimingStages.Time', 'PlayerTimingStages.TimeInZone', 'PlayerTimingStages.Attempts', 'PlayerTimingStages.Status',
                                'PlayerTimingStageInsight.StartPositionX', 'PlayerTimingStageInsight.StartPositionY', 'PlayerTimingStageInsight.StartPositionZ',
                                'PlayerTimingStageInsight.EndPositionX', 'PlayerTimingStageInsight.EndPositionY', 'PlayerTimingStageInsight.EndPositionZ',
                                'PlayerTimingStageInsight.StartAngleX', 'PlayerTimingStageInsight.StartAngleY', 'PlayerTimingStageInsight.StartAngleZ',
                                'PlayerTimingStageInsight.EndAngleX', 'PlayerTimingStageInsight.EndAngleY', 'PlayerTimingStageInsight.EndAngleZ',
                                'PlayerTimingStageInsight.StartVelocityX', 'PlayerTimingStageInsight.StartVelocityY', 'PlayerTimingStageInsight.StartVelocityZ',
                                'PlayerTimingStageInsight.EndVelocityX', 'PlayerTimingStageInsight.EndVelocityY', 'PlayerTimingStageInsight.EndVelocityZ' )
                        ->where('PlayerTimingStages.MapId', $mainRecord->MapId)
                        ->where('PlayerTimingStages.PlayerId', $mainRecord->PlayerId)
                        ->where('PlayerTimingStages.StyleId', $mainRecord->StyleId)
                        ->where('PlayerTimingStages.Level', $mainRecord->Level)
                        ->get();
            }
            else if ($type == 'Checkpoint')
            {
                $stageRecords = DB::table('PlayerTimingCheckpoints')
                        ->join('PlayerTimingCheckpointInsight', 'PlayerTimingCheckpoints.Id', '=', 'PlayerTimingCheckpointInsight.PlayerTimingCheckpointId')
                        ->select('PlayerTimingCheckpoints.Id', 'PlayerTimingCheckpoints.MapId', 'PlayerTimingCheckpoints.PlayerId', 'PlayerTimingCheckpoints.StyleId', 'PlayerTimingCheckpoints.Level', 'PlayerTimingCheckpoints.Checkpoint', 'PlayerTimingCheckpoints.Time', 'PlayerTimingCheckpoints.Status',
                                'PlayerTimingCheckpointInsight.PositionX', 'PlayerTimingCheckpointInsight.PositionY', 'PlayerTimingCheckpointInsight.PositionZ',
                                'PlayerTimingCheckpointInsight.AngleX', 'PlayerTimingCheckpointInsight.AngleY', 'PlayerTimingCheckpointInsight.AngleZ',
                                'PlayerTimingCheckpointInsight.VelocityX', 'PlayerTimingCheckpointInsight.VelocityY', 'PlayerTimingCheckpointInsight.VelocityZ')
                        ->where('PlayerTimingCheckpoints.MapId', $mainRecord->MapId)
                        ->where('PlayerTimingCheckpoints.PlayerId', $mainRecord->PlayerId)
                        ->where('PlayerTimingCheckpoints.StyleId', $mainRecord->StyleId)
                        ->where('PlayerTimingCheckpoints.Level', $mainRecord->Level)
                        ->get();
            }

            $this->checkExists($stageRecords);

            $stageRecords = (array)$stageRecords;
            $mainRecord = (array)$mainRecord;

            array_push($mainRecord, $stageRecords);
            # Checkpoint/Stage End

            array_push($detailedRecords, $mainRecord);
        }

        return response()->json($detailedRecords);
    }

    public function GetMapPlayerRecord(Request $request, $MapId, $PlayerId)
    {
        $records = DB::table('PlayerTiming')
                        ->select('*')
                        ->where('MapId', $MapId)
                        ->where('PlayerId', $PlayerId)
                        ->groupBy(['StyleId', 'Level'])
                        ->orderBy('Time', 'asc')
                        ->get();

        $this->checkExists($records);

        $newRecords = [];

        foreach ($records as $record)
        {
            $insight = DB::table('PlayerTimingInsight')
                            ->select('*')
                            ->where('PlayerTimingId', $record->Id)
                            ->first();

            $record = (array)$record;
            $insight = (array)$insight;

            array_push($record, $insight);
            array_push($newRecords, $record);
        }

        return response()->json($newRecords);
    }
}
