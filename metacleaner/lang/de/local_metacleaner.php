<?php
// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * German language strings for the MetaCleaner local plugin.
 *
 * @package     local_metacleaner
 * @copyright   2025 Sadik Mert
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


$string['action'] = 'Aktion';
$string['affectedusers'] = 'Betroffene Nutzer';
$string['allcategories'] = 'Alle Kategorien';


$string['courseid'] = 'Kurs-ID';
$string['coursename'] = 'Kursname';


$string['deactivate'] = 'Deaktivieren';
$string['delete'] = 'Löschen';


$string['enable'] = 'Meta Cleaner aktivieren';
$string['enable_help'] = 'Aktivieren Sie die Meta Cleaner-Funktionalität, die abgelaufene Meta-Einschreibungen bereinigt.';
$string['enrolaction'] = 'Aktion für abgelaufene Meta-Einschreibungen';
$string['enrolaction_help'] = 'Wählen Sie die Aktion, die für abgelaufene Meta-Einschreibungen ausgeführt werden soll. Sie können sie entweder deaktivieren (inaktiv halten) oder vollständig löschen.';
$string['error_processing_course'] = 'Fehler bei der Verarbeitung von Kurs {$a->id}: {$a->message}';
$string['exportcsv'] = 'Als CSV exportieren';


$string['filterbycategory'] = 'Nach Kategorie filtern';
$string['filterbycategory_help'] = 'Bereinige nur Kurse in der ausgewählten Kategorie.';


$string['invalid_action'] = 'Ungültige Aktionseinstellung. Bereinigung wird übersprungen.';
$string['invalid_config'] = 'Ungültige Konfiguration für maximale Nutzeranzahl oder Mindesttage. Bereinigung wird übersprungen.';
$string['invalid_user_count'] = 'Kurs {$a} wird übersprungen, da die Nutzeranzahl ungültig ist.';


$string['maxusers'] = 'Maximale Anzahl von Nutzern';
$string['maxusers_help'] = 'Bereinige nur Kurse mit weniger als dieser Anzahl von Nutzern.';
$string['meta_enrolment_note'] = '<span style="color: red;">Wird das Kursende verlängert oder entfernt, werden die deaktivierten Meta-Einschreibungen automatisch durch dieses Plugin reaktiviert.</span>';
$string['metacleaner:manage'] = 'Das MetaCleaner-Plugin verwalten';
$string['metaenrolcleanup'] = 'Meta-Einschreibungsbereinigung';
$string['metaenrolments'] = 'Meta-Einschreibungen';
$string['mindays'] = 'Minimale Tage seit Kursende';
$string['mindays_help'] = 'Bereinige nur Kurse, die vor mindestens so vielen Tagen beendet wurden.';
$string['missing_course_data'] = 'Kurs {$a} wird übersprungen, da Enddatum oder Kategorie fehlen.';
$string['missing_customint1'] = 'Einschreibung {$a} wird übersprungen, da customint1 fehlt.';


$string['no_expired_courses'] = 'Keine abgelaufenen Kurse gefunden. Vorgang wird beendet.';
$string['no_meta_enrolments'] = 'Keine Meta-Einschreibungen für Kurs {$a} gefunden. Kurs wird übersprungen.';
$string['nocourses'] = 'Keine Kurse entsprechen den ausgewählten Kriterien.';


$string['plugin_disabled'] = 'Meta Cleaner ist deaktiviert. Vorgang wird beendet.';
$string['pluginname'] = 'Meta Cleaner';
$string['pluginnotenabled'] = 'Meta Cleaner ist nicht aktiviert.';
$string['previewheading'] = 'Vorschau der betroffenen Kurse';
$string['privacy:metadata'] = 'Das MetaCleaner-Plugin speichert keine personenbezogenen Daten.';
$string['processing_course'] = 'Kurs {$a->id} ({$a->fullname}) mit {$a->users} Nutzern wird verarbeitet.';


$string['reactivated_meta_enrolment'] = 'Meta-Einschreibung mit der ID {$a} wurde reaktiviert.';
