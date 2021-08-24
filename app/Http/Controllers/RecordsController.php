<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecordsController extends Controller
{
    public function GetMapRecord(Request $request, $MapId) {
        $mainRecords = DB::table('PlayerTiming')
                        ->join('PlayerTimingInsight', 'PlayerTiming.Id', '=', 'PlayerTimingInsight.PlayerTimingId')
                        ->join('Player', 'PlayerTiming.PlayerId', '=', 'Player.Id')
                        ->select('PlayerTiming.Id', 'PlayerTiming.MapId', 'PlayerTiming.PlayerId', 'Player.Name', 'PlayerTiming.StyleId', 'PlayerTiming.Level', 'PlayerTiming.Type', 'PlayerTiming.Tickrate', 'PlayerTiming.Time', 'PlayerTiming.TimeInZone', 'PlayerTiming.Attempts', 'PlayerTiming.Status',
                                'PlayerTimingInsight.StartPositionX', 'PlayerTimingInsight.StartPositionY', 'PlayerTimingInsight.StartPositionZ',
                                'PlayerTimingInsight.EndPositionX', 'PlayerTimingInsight.EndPositionY', 'PlayerTimingInsight.EndPositionZ',
                                'PlayerTimingInsight.StartAngleX', 'PlayerTimingInsight.StartAngleY', 'PlayerTimingInsight.StartAngleZ',
                                'PlayerTimingInsight.EndAngleX', 'PlayerTimingInsight.EndAngleY', 'PlayerTimingInsight.EndAngleZ',
                                'PlayerTimingInsight.StartVelocityX', 'PlayerTimingInsight.StartVelocityY', 'PlayerTimingInsight.StartVelocityZ',
                                'PlayerTimingInsight.EndVelocityX', 'PlayerTimingInsight.EndVelocityY', 'PlayerTimingInsight.EndVelocityZ' )
                        ->where('PlayerTiming.MapId', $MapId)
                        ->groupBy('PlayerTiming.StyleId', 'PlayerTiming.Level')
                        ->orderBy('PlayerTiming.Time', 'asc')
                        ->get();

        $this->checkExists($mainRecords);

        $detailedRecords = [];

        foreach ($mainRecords as $mainRecord) {
            # Checkpoint/Stage Start
            $addRecords = null;

            if ($mainRecord->Type == 'Stage') {
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
            else if ($mainRecord->Type == 'Checkpoint') {
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

            $mainRecord = array_merge($mainRecord, $addRecords);
            $mainRecord = str_replace('\\u0000', '', json_encode($mainRecord));
            $mainRecord = json_decode($mainRecord);
            # Checkpoint/Stage End

            array_push($detailedRecords, $mainRecord);
        }

        return response()->json($detailedRecords);
    }

    public function GetMapPlayerRecord(Request $request, $MapId, $PlayerId) {
        $mainRecords = DB::table('PlayerTiming')
                        ->join('PlayerTimingInsight', 'PlayerTiming.Id', '=', 'PlayerTimingInsight.PlayerTimingId')
                        ->join('Player', 'PlayerTiming.PlayerId', '=', 'Player.Id')
                        ->select('PlayerTiming.Id', 'PlayerTiming.MapId', 'PlayerTiming.PlayerId', 'Player.Name', 'PlayerTiming.StyleId', 'PlayerTiming.Level', 'PlayerTiming.Tickrate', 'PlayerTiming.Type', 'PlayerTiming.Time', 'PlayerTiming.TimeInZone', 'PlayerTiming.Attempts', 'PlayerTiming.Status',
                                'PlayerTimingInsight.StartPositionX', 'PlayerTimingInsight.StartPositionY', 'PlayerTimingInsight.StartPositionZ',
                                'PlayerTimingInsight.EndPositionX', 'PlayerTimingInsight.EndPositionY', 'PlayerTimingInsight.EndPositionZ',
                                'PlayerTimingInsight.StartAngleX', 'PlayerTimingInsight.StartAngleY', 'PlayerTimingInsight.StartAngleZ',
                                'PlayerTimingInsight.EndAngleX', 'PlayerTimingInsight.EndAngleY', 'PlayerTimingInsight.EndAngleZ',
                                'PlayerTimingInsight.StartVelocityX', 'PlayerTimingInsight.StartVelocityY', 'PlayerTimingInsight.StartVelocityZ',
                                'PlayerTimingInsight.EndVelocityX', 'PlayerTimingInsight.EndVelocityY', 'PlayerTimingInsight.EndVelocityZ' )
                        ->where('PlayerTiming.MapId', $MapId)
                        ->where('PlayerTiming.PlayerId', $PlayerId)
                        ->groupBy('PlayerTiming.StyleId', 'PlayerTiming.Level')
                        ->orderBy('PlayerTiming.Time', 'asc')
                        ->get();

        $this->checkExists($mainRecords);

        $detailedRecords = [];

        foreach ($mainRecords as $mainRecord) {
            # Checkpoint/Stage Start
            $addRecords = null;

            if ($mainRecord->Type == 'Stage') {
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
            else if ($mainRecord->Type == 'Checkpoint') {
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

            $mainRecord = array_merge($mainRecord, $addRecords);
            $mainRecord = str_replace('\\u0000', '', json_encode($mainRecord));
            $mainRecord = json_decode($mainRecord);
            # Checkpoint/Stage End

            array_push($detailedRecords, $mainRecord);
        }

        return response()->json($detailedRecords);
    }

    public function InsertRecord(Request $request) {
        try {
            $PlayerTimingId = DB::table('PlayerTiming')->insertGetId([
                'MapId' => $request->MapId,
                'PlayerId' => $request->PlayerId,
                'StyleId' => $request->StyleId,
                'Level' => $request->Level,
                'Type' => $request->Type,
                'Tickrate' => $request->Tickrate,
                'Time' => $request->Time,
                'TimeInZone' => $request->TimeInZone,
                'Attempts' => $request->Attempts
            ]);

            DB::table('PlayerTimingInsight')->insert([
                'PlayerTimingId' => $PlayerTimingId,
                'StartPositionX' => $request->StartPositionX,
                'StartPositionY' => $request->StartPositionY,
                'StartPositionZ' => $request->StartPositionZ,
                'EndPositionX' => $request->EndPositionX,
                'EndPositionY' => $request->EndPositionY,
                'EndPositionZ' => $request->EndPositionZ,
                'StartAngleX' => $request->StartAngleX,
                'StartAngleY' => $request->StartAngleY,
                'StartAngleZ' => $request->StartAngleZ,
                'EndAngleX' => $request->EndAngleX,
                'EndAngleY' => $request->EndAngleY,
                'EndAngleZ' => $request->EndAngleZ,
                'StartVelocityX' => $request->StartVelocityX,
                'StartVelocityY' => $request->StartVelocityY,
                'StartVelocityZ' => $request->StartVelocityZ,
                'EndVelocityX' => $request->EndVelocityX,
                'EndVelocityY' => $request->EndVelocityY,
                'EndVelocityZ' => $request->EndVelocityZ
            ]);

            if ($request->Type == "Stage") {
                foreach ($request->Details as $record) {
                    $PlayerTimingStageId = DB::table('PlayerTimingStage')->insertGetId([
                        'PlayerTimingId' => $PlayerTimingId,
                        'Stage' => $record['Stage'],
                        'Time' => $record['Time'],
                        'TimeInZone' => $record['TimeInZone'],
                        'Attempts' => $record['Attempts']
                    ]);

                    DB::table('PlayerTimingStageInsight')->insert([
                        'PlayerTimingStageId' => $PlayerTimingStageId,
                        'StartPositionX' => $request->StartPositionX,
                        'StartPositionY' => $request->StartPositionY,
                        'StartPositionZ' => $request->StartPositionZ,
                        'EndPositionX' => $request->EndPositionX,
                        'EndPositionY' => $request->EndPositionY,
                        'EndPositionZ' => $request->EndPositionZ,
                        'StartAngleX' => $request->StartAngleX,
                        'StartAngleY' => $request->StartAngleY,
                        'StartAngleZ' => $request->StartAngleZ,
                        'EndAngleX' => $request->EndAngleX,
                        'EndAngleY' => $request->EndAngleY,
                        'EndAngleZ' => $request->EndAngleZ,
                        'StartVelocityX' => $request->StartVelocityX,
                        'StartVelocityY' => $request->StartVelocityY,
                        'StartVelocityZ' => $request->StartVelocityZ,
                        'EndVelocityX' => $request->EndVelocityX,
                        'EndVelocityY' => $request->EndVelocityY,
                        'EndVelocityZ' => $request->EndVelocityZ
                    ]);
                }
            }
            else if ($request->Type == "Checkpoint") {
                foreach ($request->Details as $record) {
                    $PlayerTimingCheckpointId = DB::table('PlayerTimingCheckpoint')->insertGetId([
                        'PlayerTimingId' => $PlayerTimingId,
                        'Checkpoint' => $record['Checkpoint'],
                        'Time' => $record['Time']
                    ]);

                    DB::table('PlayerTimingCheckpointInsight')->insert([
                        'PlayerTimingCheckpointId' => $PlayerTimingCheckpointId,
                        'PositionX' => $request->PositionX,
                        'PositionY' => $request->PositionY,
                        'PositionZ' => $request->PositionZ,
                        'AngleX' => $request->AngleX,
                        'AngleY' => $request->AngleY,
                        'AngleZ' => $request->AngleZ,
                        'VelocityX' => $request->VelocityX,
                        'VelocityY' => $request->VelocityY,
                        'VelocityZ' => $request->VelocityZ
                    ]);
                }
            }
        }
        catch (\Illuminate\Database\QueryException $e) {
            return response()->json("Duplicate entry", 409);
        }

        return response()->json($request, 201);
    }
}
