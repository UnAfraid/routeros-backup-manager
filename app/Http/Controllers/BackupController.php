<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use URL;

class BackupController extends Controller
{
    public function download(Request $request)
    {
        if (!URL::signatureHasNotExpired($request)) {
            return response('The URL has expired.');
        }

        if (!URL::hasCorrectSignature($request)) {
            return response('Invalid URL provided');
        }

        return Storage::disk('local')->download($request->get('path'));
    }
}
