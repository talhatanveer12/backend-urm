<?php

namespace App\Http\Controllers;

use App\Models\FeedbackReview;
use App\Http\Resources\FeedbackResource;
use App\Http\Requests\StoreFeedbackReviewRequest;
use App\Http\Requests\UpdateFeedbackReviewRequest;

class FeedbackReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $feedbackReviewResource = FeedbackResource::collection(FeedbackReview::all());
        $data = ['status' => 1, 'data' => $feedbackReviewResource];
        if ($data['status']) {
            return response()->json(['status' => true, 'data' => $data['data'], 'message' => 'Get All Feedback Successfully!'], 200);
        } else {
            return response()->error([], $data['data'], 400);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFeedbackReviewRequest $request)
    {
        $inputs = $request->all();

        try {
            $feedback = FeedbackReview::create($inputs);
            $feedbackReviewResource = new FeedbackResource($feedback);
            $data = ['status' => 1, 'data' => $feedbackReviewResource];

        } catch (Throwable $e) {
            // something went wrong

            $data = ['status' => 0, 'data' => $e->getMessage()];
        }

        if ($data['status']) {
            return response()->json(['status' => true, 'data' => $data['data'], 'message' => 'Feedback Created Successfully!'], 200);
        } else {
            return response()->error([], $data['data'], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(FeedbackReview $feedbackReview)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FeedbackReview $feedbackReview)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFeedbackReviewRequest $request, FeedbackReview $feedbackReview)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FeedbackReview $feedbackReview)
    {
        //
    }
}