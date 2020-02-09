<?php

namespace Cuttle;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Arr;

class Cuttle
{
    /**
     * The exception.
     *
     * @var Exception
     */
    public $exception;

    /**
     * The message for the exception.
     *
     * @var string
     */
    public $message = null;

    /**
     * The line number of the exception.
     *
     * @var string
     */
    public $lineNumber = null;

    /**
     * The file where the exception was thrown.
     *
     * @var string
     */
    public $file = null;

    /**
     * Severity of the exception.
     *
     * @var string
     */
    public $severity = null;

    /**
     * The host.
     *
     * @var string
     */
    public $host = null;

    /**
     * The port.
     *
     * @var string
     */
    public $port = null;

    /**
     * The request method.
     *
     * @var string
     */
    public $method = null;

    /**
     * The request uri.
     *
     * @var string
     */
    public $uri = null;

    /**
     * The HTTP protocol.
     *
     * @var string
     */
    public $protocol = null;

    /**
     * The time the exception occoured.
     *
     * @var string
     */
    public $created = null;

    /**
     * The environment.
     *
     * @var string
     */
    public $environment = null;

    /**
     * The stack trace.
     *
     * @var string
     */
    public $stackTrace = [];

    /**
     * Set the HTTP status code.
     *
     * @var string
     */
    public $httpStatusCode = null;

    /**
     * Set the Exception name.
     *
     * @var string
     */
    public $exceptionName = null;

    /**
     * The HTTP status code.
     *
     * @var string
     */
    public $httpStatus = null;

    /**
     * Laravel version.
     *
     * @var string
     */
    public $laravelVersion = null;

    /**
     * Git branch.
     *
     * @var string
     */
    public $gitBranch = null;

    /**
     * Git hash.
     *
     * @var string
     */
    public $gitHash = null;

    /**
     * Capture and parse the exception.
     *
     * @param Exception $e
     * @return void
     */
    public function capture(Exception $e)
    {
        $this->exception = $e;

        $this->setHost()
            ->setPort()
            ->setFile()
            ->setMethod()
            ->setMessage()
            ->setSeverity()
            ->setProtocol()
            ->setGitStatus()
            ->setRequestUri()
            ->setHttpStatus()
            ->setLineNumber()
            ->setStackTrace()
            ->setPHPVersion()
            ->setEnvironment()
            ->setExceptionName()
            ->setLaravelVersion()
            ->setExceptionTime()
            ->setLaravelConfigCached()
            ->report();

        return $this;
    }

    /**
     * Sets laravel version
     *
     * @return void
     */
    public function setLaravelVersion()
    {
        $this->laravelVersion = app()->version();

        return $this;
    }

    /**
     * Sets the HTTP status code
     *
     * @return void
     */
    public function setHttpStatus()
    {
        $this->httpStatus = 200;

        if (in_array($this->severity, [
            'E_PARSE',
            'E_ERROR',
            'E_COMPILE_ERROR '
        ])) {
            $this->httpStatus = 500;
            return $this;
        }

        return $this;
    }

    /**
     * Sets the exception name.
     *
     * @return void
     */
    public function setExceptionName()
    {
        $this->exceptionName = get_class($this->exception);

        return $this;
    }

    /**
     * Sets the stack trace.
     *
     * @return void
     */
    public function setStackTrace()
    {
        $this->stackTrace = $this->exception->getTrace() ?? [];

        return $this;
    }

    /**
     * Sets the exception time.
     *
     * @return void
     */
    public function setEnvironment()
    {
        $this->environment = env('APP_ENV');

        return $this;
    }

    /**
     * Sets the exception time.
     *
     * @return void
     */
    public function setExceptionTime()
    {
        $this->created = Arr::get($_SERVER, 'REQUEST_TIME', null);

        return $this;
    }

    /**
     * Sets the protocol.
     *
     * @return void
     */
    public function setProtocol()
    {
        $this->protocol = Arr::get($_SERVER, 'SERVER_PROTOCOL', null);

        return $this;
    }

    /**
     * Sets the request URI.
     *
     * @return void
     */
    public function setRequestUri()
    {
        $this->uri = Arr::get($_SERVER, 'REQUEST_URI', null);

        return $this;
    }

    /**
     * Sets the HTTP method.
     *
     * @return void
     */
    public function setMethod()
    {
        $this->method = Arr::get($_SERVER, 'REQUEST_METHOD', null);

        return $this;
    }

    /**
     * Sets the host.
     *
     * @return void
     */
    public function setHost()
    {
        $this->host = Arr::get($_SERVER, 'HTTP_HOST', null);

        return $this;
    }

    /**
     * Sets the port.
     *
     * @return void
     */
    public function setPort()
    {
        $this->port = Arr::get($_SERVER, 'SERVER_PORT', null);

        return $this;
    }

    /**
     * Get the severity from the exception.
     *
     * @return void
     */
    public function setSeverity()
    {
        $severity = null;

        if (!method_exists($this->exception, 'getSeverity')) {
            $this->severity = $severity;

            return $this;
        }

        switch ($this->exception->getSeverity()) {
            case 1:
                $severity = 'E_ERROR';
                break;
            case 2:
                $severity = 'E_WARNING';
                break;
            case 4:
                $severity = 'E_PARSE';
                break;
            case 8:
                $severity = 'E_NOTICE';
                break;
            case 16:
                $severity = 'E_CORE_ERROR';
                break;
            case 32:
                $severity = 'E_CORE_WARNING';
                break;
            case 64:
                $severity = 'E_COMPILE_ERROR';
                break;
            case 128:
                $severity = 'E_COMPILE_WARNING';
                break;
            case 256:
                $severity = 'E_USER_ERROR';
                break;
            case 512:
                $severity = 'E_USER_WARNING';
                break;
            case 1024:
                $severity = 'E_USER_NOTICE';
                break;
            case 2048:
                $severity = 'E_STRICT';
                break;
            case 4096:
                $severity = 'E_RECOVERABLE_ERROR';
                break;
            case 8192:
                $severity = 'E_DEPRECATED';
                break;
            case 16384:
                $severity = 'E_USER_DEPRECATED';
                break;
            case 32767:
                $severity = 'E_ALL';
                break;
        }

        $this->severity = $severity;

        return $this;
    }

    /**
     * Get the message from the exception.
     *
     * @return void
     */
    public function setMessage()
    {
        $this->message = $this->exception->getMessage();

        return $this;
    }

    /**
     * Get the line number for the exception.
     *
     * @return void
     */
    public function setLineNumber()
    {
        $this->lineNumber = $this->exception->getLine();

        return $this;
    }

    /**
     * Get the file of the exception.
     *
     * @return void
     */
    public function setFile()
    {
        $this->file = $this->exception->getFile();

        return $this;
    }

    /**
     * Sets the PHP version.
     *
     * @return void
     */
    public function setPHPVersion()
    {
        $this->phpVersion = PHP_VERSION;

        return $this;
    }

    /**
     * Sets Laravel config cached.
     *
     * @return void
     */
    public function setLaravelConfigCached()
    {
        $this->laravel_config_cached = app()->configurationIsCached();

        return $this;
    }

    /**
     * Sets Git status.
     *
     * @return void
     */
    public function setGitStatus()
    {
        $gitBasePath = base_path() . DIRECTORY_SEPARATOR . '.git';

        if (file_exists($gitBasePath)) {
            $branchPath = $gitBasePath . DIRECTORY_SEPARATOR . 'HEAD';
            $gitBranchName = null;
            if (file_exists($branchPath)) {
                $gitStr = file_get_contents($branchPath);
                $gitBranchName = rtrim(preg_replace("/(.*?\/){2}/", '', $gitStr));
            }

            $gitPathBranch = $gitBasePath . DIRECTORY_SEPARATOR . 'refs' . DIRECTORY_SEPARATOR . 'heads' . DIRECTORY_SEPARATOR . $gitBranchName;
            $gitHash = null;
            if (file_exists($gitPathBranch)) {
                $gitHash = file_get_contents($gitPathBranch);
            }

            $this->gitHash = $gitHash;
            $this->gitBranch = $gitBranchName;
        }

        return $this;
    }

    /**
     * Get exception.
     *
     * @param Exception $e
     * @return void
     */
    public function exception()
    {
        return [
            'uri' => $this->uri,
            'file' => $this->file,
            'host' => $this->host,
            'port' => $this->port,
            'method' => $this->method,
            'message' => $this->message,
            'created' => $this->created,
            'git_hash' => $this->gitHash,
            'severity' => $this->severity,
            'protocol' => $this->protocol,
            'git_branch' => $this->gitBranch,
            'line_number' => $this->lineNumber,
            'environment' => $this->environment,
            'http_status' => $this->httpStatus,
            'php_version' => $this->phpVersion,
            'stack_trace' => json_encode($this->stackTrace),
            'exception_name' => $this->exceptionName,
            'laravel_version' => $this->laravelVersion,
            'laravel_config_cached' => $this->laravel_config_cached,
        ];

        return $this;
    }

    /**
     * Reports the exception.
     *
     * @return void
     */
    private function report()
    {
        try {
            $client = new Client();

            $client->request('POST', 'http://cuttle-nginx/exception', [
                'form_params' => $this->exception()
            ]);
        } catch (\Exception $e) {
            dd($e);
            \Log::error('Could not post exception to cuttle');
        }
    }
}
