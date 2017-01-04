<?php
/**
 * @version   $Id: google.php 24172 2014-11-19 21:52:40Z djamil $
 * @author    RocketTheme http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2015 RocketTheme, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

defined('_JEXEC') or die('Restricted access');

if (!defined('DS')) define('DS', DIRECTORY_SEPARATOR);

class RokMiniEvents3SourceGoogle extends RokMiniEvents3_SourceBase
{
    function getEvents(&$params)
    {
        //simplepie has many strict standards errors, since they are not minievents errors they have been suppressed
        jimport('simplepie.simplepie');

        require 'google' . DS . 'api-php-client' . DS . 'autoload.php';

        $events = array();

        $id      = $params->get('google_gid', '');
        $orderby = $params->get('google_orderby', 'startTime');

        $options = array(
                    'singleEvents' => true,
                    'orderBy'      => $orderby,
                    'maxResults'   => $params->get('google_maxresults', 25)
                );

        // P12 approach
        $cemail = $params->get('google_p12_email', '');
        $p12 = JPATH_ROOT . DS . ltrim($params->get('google_p12_p12', ''), DS);

        if (!$p12 || !JFile::exists($p12) || !$p12 = file_get_contents($p12)) {
            return $events['error'] = "The P12 key has not been found at the location specified.";
        }

        $client = new Google_Client();
        $client->setApplicationName('RokMiniEvents3-' . uniqid());
        $service = new Google_Service_Calendar($client);

        $credentials = new Google_Auth_AssertionCredentials($cemail, array('https://www.googleapis.com/auth/calendar.readonly'), $p12);
        $client->setAssertionCredentials($credentials);

        if ($client->getAuth()->isAccessTokenExpired()) {
            try {
                $client->getAuth()->refreshTokenWithAssertion($credentials);
            } catch (Exception $error) {
                return $events['error'] = $error->getMessage();
            }
        }

        if ($params->get('time_range') != 'time_span' && $params->get('rangespan') == 'all_events') {
            if (!$params->get('google_past', false)) {
                $options['timeMin'] = date('Y-m-d\T00:00:00\Z', time());
            } // deprecated
        } else {
            $startMin = $params->get('startmin');

            $options['timeMin'] = $startMin . 'Z';
            $startMax = $params->get('startmax', false);
            if ($startMax !== false) {
                $options['timeMax'] = $startMax . 'Z';
            }
        }

        try {
            $items = $service->events->listEvents($id, $options);
        } catch(Exception $error) {
            return $events['error'] = $error->getMessage();
        }

        if(empty($items)) return $events;
        foreach ($items as $item) {
            $link      = ($params->get('google_links') != 'link_no') ? array(
                'internal' => ($params->get('google_links') == 'link_internal') ? true : false,
                'link'     => $item->getHtmlLink()
            ) : false;

            $start = $item->getStart();
            $end = $item->getEnd();

            $startdatetime = $start->dateTime ?: $start->date;
            $enddatetime = $end->dateTime ?: $end->date;

            $startdate = str_replace('T', ' ', $startdatetime);
            $enddate   = str_replace('T', ' ', $enddatetime);
            $time_diff = (int)$enddate - (int)$startdate;

            $event = new RokMiniEvents3_Event($startdate, $enddate, $item->getSummary(), $item->getDescription(), $link);
            if ($startdate==$enddate || ($time_diff <= 86401 && $time_diff >= 86399)) $event->setAllDay(true);

            $events[] = $event;
        }
        return $events;
    }

    function available()
    {
        return true;
    }
}
