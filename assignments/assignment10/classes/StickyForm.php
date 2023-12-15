<?php
// Import the Validation class
require_once('Validation.php');

/**
 * StickyForm.php
 *
 * Class responsible for handling form validation and making the form sticky.
 * Extends the Validation class to reuse validation functionality.
 */
class StickyForm extends Validation {
    
    /**
     * Validates the form input, performs checks, and makes the form sticky.
     *
     * @param array $globalPost The POST array from the form.
     * @param array $elementsArr The elements array defining form elements.
     * @return array Updated elements array with validation results and sticky values.
     */
    public function validateForm($globalPost, $elementsArr) {
        foreach ($elementsArr as $key => $element) {
            // Check and make text fields sticky
            if ($element['type'] === "text") {
                $error = $this->checkFormat($globalPost[$key], $element['regex']);
                if ($error === 'error') {
                    $element['errorOutput'] = $element['errorMessage'];
                    $elementsArr['masterStatus']['status'] = "error";
                }
                $element['value'] = htmlentities($globalPost[$key]);
            }

            // Make select boxes sticky
            else if ($element['type'] === "select") {
                $element['selected'] = $globalPost[$key];
            }

            // Handle checkboxes
            else if ($element['type'] === 'checkbox') {
                // Validation for required checkboxes
                if ($element['action'] == "required" && !isset($globalPost[$key])) {
                    $element['errorOutput'] =  $element['errorMessage'];
                    $elementsArr['masterStatus']['status'] = "error";
                } else {
                    // Make checkboxes sticky
                    if (isset($globalPost[$key])) {
                        foreach ($element['status'] as $ek => $ev) {
                            foreach ($globalPost[$key] as $gv) {
                                if ($ek === $gv) {
                                    $element['status'][$ek] = "checked";
                                    break;
                                }
                            }
                        }
                    }
                }
            }

            // Handle radio buttons
            else if ($element['type'] === 'radio') {
                // Validation for required radio groups
                if ($element['action'] == "required" && !isset($globalPost[$key])) {
                    $element['errorOutput'] =  $element['errorMessage'];
                    $elementsArr['masterStatus']['status'] = "error";
                } else {
                    // Make radio buttons sticky
                    if (isset($globalPost[$key])) {
                        foreach ($element['value'] as $ek => $ev) {
                            if ($globalPost[$key] === $ek) {
                                $element['value'][$ek] = "checked";
                                break;
                            }
                        }    
                    }
                }
            }

            // Update the elements array
            $elementsArr[$key] = $element;
        }

        return $elementsArr;
    }

    /**
     * Creates options for select boxes dynamically.
     *
     * @param array $elementsArr The elements array defining form elements.
     * @return string HTML options for select boxes.
     */
    public function createOptions($elementsArr) {
        $options = '';
        foreach ($elementsArr['options'] as $k => $v) {
            $isSelected = ($elementsArr['selected'] == $k) ? 'selected' : '';
            $options .= "<option $isSelected value=$k>$v</option>";
        }
        return $options;
    }
}
?>
