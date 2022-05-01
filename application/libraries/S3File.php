<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use Aws\S3\S3Client;

/**
 * Class permettant de gérer de façon transparente la gestion des fichiers uploader que ce soit sur disque ou sous S3
 */
class S3File {

    protected $_bucket;
    protected $_region;
    protected $_isOnline;
    protected $_sdk;
    protected $_client;
    protected $_url;

    public function __construct($params = array()) {
        $CI =& get_instance();
        $this->_isOnline = $CI->config->item('aws_s3')===true;
        if($this->_isOnline) {
            $this->_region = $CI->config->item('aws_s3_region');
            $this->_bucket = $CI->config->item('aws_s3_bucket');
            $this->_sdk = new Aws\Sdk(array(
                'region'   => $this->_region,
                'version'  => 'latest'
            ));
            $this->_client = $this->_sdk->createS3();
            $this->_url = $CI->config->item('aws_s3_url');
        }
        else {
            $this->_url = $CI->config->item('base_url');
        }
    }

	public function file_put_contents($fileName, $data) {
		 if(!$this->_isOnline) {
            return file_put_contents($fileName, $data);
        }
        else {
            return $this->_client->putObject(array(
                'Bucket'       => $this->_bucket,
                'Key'          => $fileDest,
                'Body'  => $data,
                'ContentType'  => 'text/plain',
                'ACL'          => 'public-read',
                'StorageClass' => 'REDUCED_REDUNDANCY'
            ));        	
		}
	}

    public function move_uploaded_file($fileName, $fileDest) {
        if(!$this->_isOnline) {
            return move_uploaded_file($fileName, $fileDest);
        }
        else {
            return $this->_client->putObject(array(
                'Bucket'       => $this->_bucket,
                'Key'          => $fileDest,
                'SourceFile'   => $fileName,
                'ContentType'  => 'text/plain',
                'ACL'          => 'public-read',
                'StorageClass' => 'REDUCED_REDUNDANCY'
            ));
        }
    }

    public function unlink($fileName) {
        if(!$this->_isOnline) {
            return unlink($fileName);
        }
        else {
            return $this->_client->deleteObject(array(
                'Bucket'  => $this->_bucket,
                'Key'     => $fileName
            ));
        }
    }

    public function file_exists($fileName) {
        if(!$this->_isOnline) {
            return file_exists($fileName);
        }
        else {
            return $this->_client->doesObjectExist($this->_bucket, $fileName);

        }
    }

    public function getUrl($fileName) {
    	if(substr( $fileName, 0, 4 ) === "http") return $fileName;
		else return $this->_url . $fileName;
	}

}
/*
$bucket = 'cowanted.prod';
$keyname = 'test';
// $filepath should be absolute path to a file on disk
$filepath = '/var/app/current/upload/cover/cover_profil.png';

// Instantiate the client.
$s3 = S3Client::factory(array(
'region' => 'eu-west-1',
'version' => 'latest'
));

// Upload a file.
$result = $s3->putObject(array(
'Bucket'       => $bucket,
'Key'          => "upload/avatar/$keyname",
'SourceFile'   => $filepath,
'ContentType'  => 'text/plain',
'ACL'          => 'public-read',
'StorageClass' => 'REDUCED_REDUNDANCY'
));

echo $result['ObjectURL'];
exit;
https://s3-eu-west-1.amazonaws.com/cowanted.prod/upload/avatar/test
https://preprod-env2.elasticbeanstalk.com/upload/avatar/test
*/