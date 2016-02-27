<?php

namespace Ruddy\FileSystem;

/**
 * Ruddy Framework FileSystem
 * 
 * @author Nick Vlug <nick@ruddy.nl>
 * @author Gil Nimer <gil@ruddy.nl>
 */

class FileSystem
{
    /**
     * driver String
     *
     * @var string
     */
    protected $driverStr = "";
    
    /**
     * driver Interface
     * @var drivers\Idriver();
     */
    protected $driver = null;

    /**
     * Drivers array
     * @var array
     */
    protected $drivers = array('DIRECT', 'FTP');

    /**
     * Constructor
     */
    public function __construct()
    {

    }

    /**
     * Get the driver in String format
     *
     * @return string
     */
    public function getDriverStr()
    {
        return $this->driverStr;
    }

    /**
     * Set driver to use in the FileSystem
     *
     * @param $string
     * @throws \Exception
     */
    public function setdriver($string)
    {
        if(in_array($string, $this->drivers)){
            $this->driverStr = $string;
            $driver = "\\Ruddy\\FileSystem\\Drivers\\{$string}";
            $this->driver = new $driver();
        } else {
            throw new \Exception("FileSystem driver does not exists", "500");
        }
    }

    /**
     * Connect FTP
     *
     * @param $server
     * @param $username
     * @param $password
     * @return mixed
     * @throws \Exception
     */
    public function connFTP($server, $username, $password, $tmpDir = TMP_FTP)
    {
        if(is_null($this->driver) || $this->driverStr != "FTP")
        {
            throw new \Exception("FileSystem driver must be FTP", "500");
        }
        return $this->driver->connFTP($server, $username, $password, $tmpDir);
    }

    /**
     * Close FTP connection
     *
     * @return mixed
     * @throws \Exception
     */
    public function closeFTP()
    {
        if(is_null($this->driver) || $this->driverStr != "FTP")
        {
            throw new \Exception("FileSystem driver must be FTP", "500");
        }
        return $this->driver->closeFTP();
    }

    /**
     * Uploads a file to the FTP server /from an open file
     *
     * @param $remote_file
     * @param $local_file
     * @param bool $fopen
     * @param null $mode
     * @param null $ftp_stream
     * @return bool
     */
    public function putFTP($remote_file, $local_file, $mode = null, $fopen = false, $ftp_stream = null)
    {
        if(is_string($local_file) !== true || is_string($remote_file) !== true || is_null($this->driver))
        {
            return false;
        }
        return $this->driver->putFTP($remote_file, $local_file, $mode, $fopen, $ftp_stream);
    }

    /**
     * Downloads a file from the FTP server /to an open file
     *
     * @param $local_file
     * @param $remote_file
     * @param bool $fopen
     * @param null $mode
     * @param null $ftp_stream
     * @return bool
     */
    public function getFTP($local_file, $remote_file, $mode = null, $fopen = false, $ftp_stream = null)
    {
        if(is_string($local_file) !== true || is_string($remote_file) !== true || is_null($this->driver))
        {
            return false;
        }
        return $this->driver->getFTP($local_file, $remote_file, $mode, $fopen, $ftp_stream);
    }

    /**
     * Tells whether the filename is a directory
     *
     * @param $dirname
     * @return bool
     */
    public function isDir($dirname)
    {
        if(is_string($dirname) !== true || is_null($this->driver))
        {
            return false;
        }
        return $this->driver->isDir($dirname);
    }

    /**
     * Tells whether the filename is a regular file
     *
     * @param $filename
     * @return bool
     */
    public function isFile($filename)
    {
        if(is_string($filename) !== true || is_null($this->driver))
        {
            return false;
        }
        return $this->driver->isFile($filename);
    }

    /**
     * Makes directory
     *
     * @param $dirname
     * @param int $mode
     * @param bool $recursive
     * @return bool
     */
    public function mkDir($dirname, $mode = 0777, $recursive = false)
    {
        if(is_string($dirname) !== true || is_numeric($mode) !== true || is_null($this->driver))
        {
            return false;
        }
        return $this->driver->mkdir($dirname, $mode, $recursive);
    }

    /**
     * Removes directory
     *
     * @param $dirname
     * @return bool
     */
    public function rmDir($dirname) 
    {
        if(is_string($dirname) !== true || is_null($this->driver))
        {
            return false;
        }
        return $this->driver->rmdir($dirname);
    }

    /**
     * Deletes a file
     *
     * @param $filename
     * @return bool
     */
    public function delete($filename)
    {
        if(is_string($filename) !== true || is_null($this->driver))
        {
            return false;
        }
        return $this->driver->delete($filename);
    }

    /**
     * Copies file
     *
     * @param $source
     * @param $dest
     * @return bool
     */
    public function copy($source, $dest)
    {
        if(is_string($source) !== true || is_string($dest) !== true || is_null($this->driver))
        {
            return false;
        }
        return $this->driver->copy($source, $dest);
    }

    /**
     * Renames a file or directory
     *
     * @param $oldname
     * @param $newname
     * @return bool
     */
    public function rename($oldname, $newname)
    {
        if(is_string($oldname) !== true || is_string($newname) !== true || is_null($this->driver))
        {
            return false;
        }
        return $this->driver->rename($oldname, $newname);
    }

    /**
     * Gets file modification time
     *
     * @param $filename
     * @return bool
     */
    public function fileMTime($filename)
    {
        if(is_string($filename) !== true || is_null($this->driver))
        {
            return false;
        }
        return $this->driver->filemtime($filename);
    }

    /**
     * Reads entire file into a string
     *
     * @param $filename
     * @return bool
     */
    public function fileGetContents($filename)
    {
        if(is_string($filename) !== true || is_null($this->driver))
        {
            return false;
        }
        return $this->driver->fileGetContents($filename);
    }

    /**
     * Write a string to a file
     *
     * @param $filename
     * @param $data
     * @return bool
     */
    public function filePutContents($filename, $data)
    {
        if(is_string($filename) !== true || is_string($data) !== true || is_null($this->driver))
        {
            return false;
        }
        return $this->driver->filePutContents($filename, $data);
    }
}