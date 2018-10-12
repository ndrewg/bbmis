<?php
include ("../connections.php");




$expected_donor = mysqli_query($connections,"SELECT DISTINCT(d.intDonationId), c.intClientId, CONCAT(strClientFirstName, ' ', strClientMiddleName, ' ', strClientLastName) AS Applicant_DonorName, dtmExamTaken
                                                FROM tbldonation d JOIN tblclient c ON d.intClientId = c.intClientId JOIN tblmedicalexam m ON d.intDonationId = m.intDonationId
                                                WHERE d.intDonationId NOT IN (SELECT intDonationId FROM tblmedicalexam WHERE stfAnswerRemarks = 'Wrong' OR stfAnswerRemarks ='Unchecked')
                                                AND d.intDonationId NOT IN(SELECT intDonationId FROM tblphysicalexam)
                                                AND stfDonationRemarks = 'Incomplete'
                                                AND dtmExamTaken BETWEEN DATE_SUB(NOW(), INTERVAL 3 DAY) AND NOW()
                                                GROUP BY 1");

            if(mysqli_num_rows($expected_donor) > 0){

                    $output = "
                             <table class='table table-bordered text-center' id='tbldonorsurvey'>
                             <thead>
                             <tr >
                             <th>Exam Code</th>
                             <th>Donor Code</th>
                             <th>Donor/Applicant Name</th>
                             <th>Date</th>
                             </tr>
                           </thead>";

          while ($row = mysqli_fetch_assoc($expected_donor)) {
            $exam = $row["intDonationId"];
            $donor_id = $row["intClientId"];
            $donor_name = $row["Applicant_DonorName"];
            $date = $row["dtmExamTaken"];

              $output .= "
             <tbody>
             <tr>
             <td>$exam</td>
             <td>$donor_id</td>
             <td>$donor_name</td>
             <td>$date</td>

             </tr>
           </tbody>";

  }

  $output .="
</table>";
echo $output;

}else{

}


?>
