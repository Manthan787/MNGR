<?php

class AnswersheetHelper {

    public static function displayTables($answers) {
        $output = '';
        foreach($answers as $index => $answer) {
            if($index % 25 == 0) {
              $output .= '</table><table>';
              $output .= '
               <tbody>
                    <tr>
                      <td style="font-weight:bold">'.++$index.'</td>
                      <td>'.chr(65+$answer).'</td>
                    </tr>
              </tbody>';
            }
            else {
               $output.= '
                <tbody>
                     <tr>
                       <td style="font-weight:bold">'.++$index.'</td>
                       <td>'.chr(65+$answer).'</td>
                     </tr>
               </tbody>';
            }
        }
        $output .= '</table>';
        return $output;
    }

}


 ?>
