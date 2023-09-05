<?php

namespace App\Exceptions;

use App\Models\FailLog;
use Exception;
use Illuminate\Support\Facades\Log;

class TradeFailException extends Exception
{
    public $data;

    public function __construct($message, $data = null)
    {
        parent::__construct($message);

        $this->data = $data;
    }

    public function report()
    {
        FailLog::create([
            'exception_message' => $this->getMessage(),
            'exception_data' => json_encode($this->data),
        ]);

        Log::error($this->getMessage(), ['exception_data' => $this->data]);
    }

    public function render() {
        return back()->with('notify', [
            'type' => 'error', 'header' => 'An Error Occured', 'body' => 'Check the fail log for details'
        ]);
    }
}
