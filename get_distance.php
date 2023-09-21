<?php
    include("../inc/dbconn.php");
    include("distance-calculator-n.php");

    $data = json_decode(file_get_contents('php://input'));

    if(!empty($data->latitude) && !empty($data->longitude) && !empty($data->service_id))
    {
        $latitudeTo = $data->latitude;
        $longitudeTo = $data->longitude;
        $sid = $data->service_id;

        $nullarray = array();
        $sql = "SELECT * FROM hotel WHERE service='$sid'";
        $result = $conn->query($sql);
        $i = 0;
        if($result->num_rows > 0)
        {
            while($row = $result->fetch_assoc())
            {
                $id = $row["lid"];
                $latitudeFrom = $row["lati"];
                $longitudeFrom = $row["longi"];

                $nullarray[$id] = getDistance($latitudeFrom,$longitudeFrom,$latitudeTo,$longitudeTo);

                $i++;
            }
            
            $not = asort($nullarray);
            $tem = array();
            $i = 0;
            $json = "";

            $sql3 = "SELECT * FROM charges WHERE id='1'";
            $result3 = $conn->query($sql3);
            $row3 = $result3->fetch_assoc();

            foreach($nullarray as $x => $x_value)
            {
                $sql1 = "SELECT * FROM hotel WHERE lid='$x'";
                $result1 = $conn->query($sql1);
                $row1 = $result1->fetch_assoc();

                $k = $rating = $totrate = 0;

                $sql4 = "SELECT * FROM rating WHERE landid='$x'";
                $result4 = $conn->query($sql4);
                if($result4->num_rows > 0)
                {
                    while($row4 = $result4->fetch_assoc())
                    {
                        $rating += $row4["rating"];
                        $k++;
                    }

                    $totrate = $rating/$k;
                }

                $sql2 = "SELECT * FROM login WHERE id='$x'";
                $result2 = $conn->query($sql2);
                $row2 = $result2->fetch_assoc();

                $cityid = $row2["city"];

                $sql5 = "SELECT * FROM city WHERE id='$cityid'";
                $result5 = $conn->query($sql5);
                $row5 = $result5->fetch_assoc();

                if($x_value <= $row3["maxdistance"])
                {
                    $tem["Rapry"][$i]["id"] = $row1["lid"];
                    $tem["Rapry"][$i]["city_id"] = $row2["city"];
                    $tem["Rapry"][$i]["city_name"] = $row5["name"];
                    $tem["Rapry"][$i]["Restaurant_name"] = $row1["name"];
                    $tem["Rapry"][$i]["Restaurant_intime"] = date('H:i',strtotime($row1["intime"]));
                    $tem["Rapry"][$i]["Restaurant_outtime"] = date('H:i',strtotime($row1["outtime"]));
                    $tem["Rapry"][$i]["Restaurant_status"] = $row1["res_status"];
                    $tem["Rapry"][$i]["Restaurant_rating"] = (string)$totrate;
                    $tem["Rapry"][$i]["delivery_time"] = $row1["time"];
                    $tem["Rapry"][$i]["special"] = $row1["special"];
                    $tem["Rapry"][$i]["brand"] = $row1["brand"];
                    $tem["Rapry"][$i]["low_price"] = $row1["low"];
                    $tem["Rapry"][$i]["exclusive"] = $row1["exclusive"];
                    $tem["Rapry"][$i]["Restaurant_image"] = $row1["image"];
                    $tem["Rapry"][$i]["distance"] = $x_value." Km";
                    $tem["Rapry"][$i]["offer"] = $row1["ppercent"]."% OFF";
                    $tem["Rapry"][$i]["licence_number"] = $row1["licence_number"];

                    $json = json_encode($tem);
                    $i++;
                }
            }

            if($i == 0)
            {
                http_response_code(200);

                $myObj = new \stdClass();
                $myObj->status = "fail";
                $myObj->message = "No Restaurant Found.";
                $json = json_encode($myObj);
            }
            else
            {
                $tem["status"] = "success";
                $tem["message"] = "Restaurants Found";
                $json = json_encode($tem);
            }
            echo $json;
        }
        else
        {
            http_response_code(200);

            $myObj = new \stdClass();
            $myObj->status = "fail";
            $myObj->message = "No Restaurant Found.";
            $myJSON = json_encode($myObj);
            echo $myJSON;
        }
    }
    else
    {
        http_response_code(200);

        $myObj = new \stdClass();
        $myObj->status = "fail";
        $myObj->message = "No Restaurant Available.Data is Incomplete.";
        $myJSON = json_encode($myObj);
        echo $myJSON;
    }

?>