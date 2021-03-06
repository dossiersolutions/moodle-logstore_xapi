<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

namespace MXTranslator\Tests;

defined('MOODLE_INTERNAL') || die();

use \MXTranslator\Events\ScormScoreRawSubmitted as Event;

class scorm_score_raw_submitted_test extends scorm_event_test {
    protected static $recipename = 'scorm_scoreraw_submitted';

    /**
     * Sets up the tests.
     * @override TestCase
     */
    public function setup() {
        parent::setup();
        $this->event = new Event();
    }

    protected function construct_input() {
        return array_merge(parent::construct_input(), [
            'scorm_scoes_track' => [
                'scoremax' => 100,
                'scoremin' => 0,
                'status' => 'status',
            ],
            'cmi_data' => [
                'cmivalue' => 100,
                'cmielement' => 'cmi.core.score.raw',
                'attemptid' => 1,
            ],
            'scorm_scoes' => $this->construct_scorm_scoes()
        ]);
    }

    protected function assert_output($input, $output) {
        parent::assert_output($input, $output);
        $this->assertEquals($input['module']->name, $output['scorm_name']);
        $this->assertEquals($input['module']->url, $output['scorm_url']);
        $this->assertEquals($input['module']->url, $output['scorm_scoes_url']);
        $this->assertEquals($input['scorm_scoes']->title, $output['scorm_scoes_name']);
        $this->assertEquals($input['scorm_scoes']->id, $output['scorm_scoes_id']);
        $this->assertEquals($input['scorm_scoes_track']['scoremin'], $output['scorm_score_min']);
        $this->assertEquals($input['scorm_scoes_track']['scoremax'], $output['scorm_score_max']);
        $this->assertEquals($input['scorm_scoes_track']['status'], $output['scorm_status']);
        $this->assertEquals($input['cmi_data']['attemptid'], $output['scorm_attempt']);
    }
}
