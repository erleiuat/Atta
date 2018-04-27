<?php

    include("../../include/session.php");

    if($session_loggedin == false){
        echo '<script type="text/javascript">parent.window.location.reload();</script>';
        exit();
    }

?>
<section class="resume-section p-3 p-lg-5 d-flex d-column" id="about">
    <div class="my-auto col-12">

        <h2 class="mb-0">
            <span class="text-primary">FAQ</span>
        </h2>
        <br/>
        <div class="row">
            <div class="col-12">
                <h3>How to handle the daily max. calories</h3>
                <p>
                    The daily max. calories only describe how many calories you should take in general. So in most cases this amount won't be the correct one.<br/><br/>
                    It doesn't regard any additional burned calories, so please only stick to that number if you sleep all day. <br/>
                    Otherwise add your average burned calories from basic activities to that number to get a useable result.
                </p>
                <hr/>

                <h3>What's the BMI?</h3>
                <p>
                    Body mass index is a measure of body fat and is commonly used within the health industry to determine
                    whether your weight is healthy. BMI applies to both adult men and women and is the calculation of body
                    weight in relation to height. This article delves into the BMI formula and shows you how to calculate your
                    BMI manually using mathematics.
                </p>
                <hr/>

                <h3>How is the BMI calculated?</h3>
                <p>
                    The formula for BMI was devised in the 1830s by Belgian mathematician Adolphe Quetelet.<br/><br/>

                    BMI is universally expressed in kg/m2. If imperial units are used (pounds and inches) then
                    an additional conversion factor is applied.<br/><br/>

                    BMI = weight (kg) ÷ height<sup>2</sup> (m<sup>2</sup>)
                </p>
                <hr/>

                <h3>Other Questions or Suggestions?</h3>
                <p>
                    <a href="https://eliareutlinger.ch/"><i class="fas fa-external-link-alt"></i> Contact me</a><br/>
                    <a href="https://github.com/eliareutlinger/Atta"><i class="fab fa-github"></i></i> View on Github</a>
                </p>
            </div>
        </div>
    </div>
</section>
