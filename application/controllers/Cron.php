<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cron extends CI_Controller{
    /**
     * Cron constructor.
     */
    function __construct(){
        parent::__construct();
        if( $this->input->is_cli_request() == false )
            redirect('');
    }

    /**
     *
     */
    public function index(){die();}

    /**
     *
     */
    public function getSitemap(){
        $fp = fopen('sitemap.xml', 'w');
        fwrite($fp, '<?xml version="1.0" encoding="UTF-8"?>'."\r\n");
        fwrite($fp, '<urlset xmlns="https://www.sitemaps.org/schemas/sitemap/0.9">'."\r\n");

        /* HOMEPAGE */
        fwrite($fp, '<url>'."\r\n");
            fwrite($fp, '<loc>'.base_url().'</loc>'."\r\n");
            fwrite($fp, '<lastmod>'.date('Y-m-d').'</lastmod>'."\r\n");
            fwrite($fp, '<changefreq>weekly</changefreq>'."\r\n");
            fwrite($fp, '<priority>1</priority>'."\r\n");
        fwrite($fp, '</url>'."\r\n");

        /* Mentor page */
        fwrite($fp, '<url>'."\r\n");
            fwrite($fp, '<loc>'.base_url('mentor').'</loc>'."\r\n");
            fwrite($fp, '<lastmod>'.date('Y-m-d').'</lastmod>'."\r\n");
            fwrite($fp, '<changefreq>weekly</changefreq>'."\r\n");
            fwrite($fp, '<priority>0.8</priority>'."\r\n");
        fwrite($fp, '</url>'."\r\n");

        /* Employeur page */
        fwrite($fp, '<url>'."\r\n");
            fwrite($fp, '<loc>'.base_url('employeur').'</loc>'."\r\n");
            fwrite($fp, '<lastmod>'.date('Y-m-d').'</lastmod>'."\r\n");
            fwrite($fp, '<changefreq>weekly</changefreq>'."\r\n");
            fwrite($fp, '<priority>0.8</priority>'."\r\n");
        fwrite($fp, '</url>'."\r\n");

        /* Pages Profils Mentor */
        $this->load->model('andafter/ModelGestion', 'ModelGestion');
        $Talents                = $this->ModelGestion->getAllTalents();
        foreach ($Talents as $Talent) {
            $BusinessTalent     = new BusinessTalent( $Talent );

            fwrite($fp, '<url>'."\r\n");
                fwrite($fp, '<loc>'.base_url($BusinessTalent->getUrl().'apropos').'</loc>'."\r\n");
                fwrite($fp, '<lastmod>'.date('Y-m-d').'</lastmod>'."\r\n");
                fwrite($fp, '<changefreq>weekly</changefreq>'."\r\n");
                fwrite($fp, '<priority>0.95</priority>'."\r\n");
            fwrite($fp, '</url>'."\r\n");
        }

        fwrite($fp, '</urlset>'."\r\n");
        fclose($fp);
    }
}