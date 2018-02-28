<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//print_r($assesmentData);exit;
$curUser = currentuser_session();
?>

<!--Content-->
<div class="content">
    <div class="container">

        <div class="row">

            <div class="col-lg-12">
                <div class="row">
                    <div class="profile get-connected">
                        <!--left menu-->
                        <?php
                        if ($assesment != 0) {
                            require_once 'includes/left-menu.php';
                        }
                        else {
                            echo '<div class="col-sm-1"></div>';
                        }
                        ?>
                        <div class="col-md-9 col-sm-8">
                            <div class="assesment">
                                <h2>Assessment</h2>

                                <div class="assesment-inner">

                                    <form method="post" id="assesment-form" action="<?php echo base_url('Profile/assesment_update'); ?>" enctype="multipart/form-data">
                                        <div class="col-sm-4">
                                            <select class="form-control" id="state" name="state">
                                                <option value="">Select State</option>
                                                <?php
                                                foreach ($states as $state) {
                                                    $selected = '';
                                                    if ($state['id'] == $assesmentData['state']) {
                                                        $selected = 'selected="selected"';
                                                    }
                                                    ?>
                                                    <option value="<?php echo $state['id']; ?>" <?php echo $selected; ?>><?php echo ($state['name']) ? $state['name'] : ""; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <select class="form-control" id="city" name="city">
                                                <option value="">City</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="text"  name="zip" id="zip" placeholder="Zip Code" class="form-control" value="<?php echo ($assesmentData['zip']) ? $assesmentData['zip'] : ""; ?>"/>
                                            <span id="zip-preloader" class="hidden"><img src="<?php echo base_url('assets/images/preloader.gif'); ?>" alt=""/></span>
                                        </div>
                                        <div class="clear"></div>

                                        <div class="option-wrap">
                                            <div class="col-sm-4 marginTop5">
                                                <select class="form-control" id="interest" name="interest">
                                                    <option  value="">Show your interest</option>
                                                    <option <?php echo ($assesmentData['interest'] == 'Foreign language study') ? 'selected="selected"' : ""; ?> value="Foreign language study" >Foreign language study</option>
                                                    <option <?php echo ($assesmentData['interest'] == 'Reading') ? 'selected="selected"' : ""; ?> value="Reading">Reading</option>
                                                    <option <?php echo ($assesmentData['interest'] == 'Writing/blogging') ? 'selected="selected"' : ""; ?> value="Writing/blogging">Writing/blogging</option>
                                                    <option <?php echo ($assesmentData['interest'] == 'Music/musical instruments') ? 'selected="selected"' : ""; ?> value="Music/musical instruments">Music/musical instruments</option>
                                                    <option <?php echo ($assesmentData['interest'] == 'Jogging/walking') ? 'selected="selected"' : ""; ?> value="Jogging/walking">Jogging/walking</option>
                                                    <option <?php echo ($assesmentData['interest'] == 'Horseback riding') ? 'selected="selected"' : ""; ?> value="Horseback riding">Horseback riding</option>
                                                    <option <?php echo ($assesmentData['interest'] == 'Yoga') ? 'selected="selected"' : ""; ?> value="Yoga">Yoga</option>
                                                    <option <?php echo ($assesmentData['interest'] == 'Team sports: volleyball, bowling, soccer') ? 'selected="selected"' : ""; ?> value="Team sports: volleyball, bowling, soccer">Team sports: volleyball, bowling, soccer</option>
                                                    <option <?php echo ($assesmentData['interest'] == 'Card games') ? 'selected="selected"' : ""; ?> value="Card games">Card games</option>
                                                    <option <?php echo ($assesmentData['interest'] == 'Dinner or Movie club') ? 'selected="selected"' : ""; ?> value="Dinner or Movie club">Dinner or Movie club</option>
                                                    <option <?php echo ($assesmentData['interest'] == 'Ballroom dancing') ? 'selected="selected"' : ""; ?> value="Ballroom dancing">Ballroom dancing</option>
                                                    <option <?php echo ($assesmentData['interest'] == 'Volunteering') ? 'selected="selected"' : ""; ?> value="Volunteering">Volunteering</option>
                                                    <option <?php echo ($assesmentData['interest'] == 'Scrapbooking') ? 'selected="selected"' : ""; ?> value="Scrapbooking">Scrapbooking</option>
                                                    <option <?php echo ($assesmentData['interest'] == 'Needle arts: embroidery, cross-stitch') ? 'selected="selected"' : ""; ?> value="Needle arts: embroidery, cross-stitch">Needle arts: embroidery, cross-stitch</option>
                                                    <option <?php echo ($assesmentData['interest'] == 'Jewelry making') ? 'selected="selected"' : ""; ?> value="Jewelry making">Jewelry making</option>
                                                    <option <?php echo ($assesmentData['interest'] == 'Drawing/painting/photography') ? 'selected="selected"' : ""; ?> value="Drawing/painting/photography">Drawing/painting/photography</option>
                                                    <option <?php echo ($assesmentData['interest'] == 'Pottery') ? 'selected="selected"' : ""; ?> value="Pottery">Pottery</option>
                                                    <option <?php echo ($assesmentData['interest'] == 'Antiques') ? 'selected="selected"' : ""; ?> value="Antiques">Antiques</option>
                                                    <option <?php echo ($assesmentData['interest'] == 'Decor') ? 'selected="selected"' : ""; ?> value="Decor">Decor</option>
                                                    <option <?php echo ($assesmentData['interest'] == 'Postcards') ? 'selected="selected"' : ""; ?> value="Postcards">Postcards</option>
                                                    <option <?php echo ($assesmentData['interest'] == 'Genealogy') ? 'selected="selected"' : ""; ?> value="Genealogy">Genealogy</option>
                                                    <option <?php echo ($assesmentData['interest'] == 'Hiking/letterboxing/geocaching') ? 'selected="selected"' : ""; ?> value="Hiking/letterboxing/geocaching">Hiking/letterboxing/geocaching</option>
                                                    <option <?php echo ($assesmentData['interest'] == 'Bird-watching') ? 'selected="selected"' : ""; ?> value="Bird-watching">Bird-watching</option>
                                                    <option <?php echo ($assesmentData['interest'] == 'Hunting/fishing') ? 'selected="selected"' : ""; ?> value="Hunting/fishing">Hunting/fishing</option>
                                                    <option <?php echo ($assesmentData['interest'] == 'Cooking/baking') ? 'selected="selected"' : ""; ?> value="Cooking/baking">Cooking/baking</option>
                                                    <option <?php echo ($assesmentData['interest'] == 'Knitting') ? 'selected="selected"' : ""; ?> value="Knitting">Knitting</option>
                                                    <option <?php echo ($assesmentData['interest'] == 'Quilting') ? 'selected="selected"' : ""; ?> value="Quilting">Quilting</option>
                                                    <option <?php echo ($assesmentData['interest'] == 'information_technology') ? 'selected="selected"' : ""; ?> value="information_technology">Information Technology</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-4 marginTop5">
                                                <input type="text" name="dob" id="dob" class="form-control" placeholder="Date of Birth" value="<?php echo $assesmentData['dob']; ?>"/>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="col-sm-3">
                                                <div class="chose-option marginTop10">
                                                    <h4>I am...</h4>
                                                    <ul>
                                                        <li>
                                                            <input type="radio" id="f-option" name="profession" value="student" <?php echo ($assesmentData['profession'] == 'student') ? 'checked="checked"' : ""; ?>>
                                                            <label for="f-option">A student</label>

                                                            <div class="check"></div>
                                                        </li>

                                                        <li>
                                                            <input type="radio" id="s-option" name="profession" value="professional" <?php echo ($assesmentData['profession'] == 'professional') ? 'checked="checked"' : ""; ?>>
                                                            <label for="s-option">A professional</label>

                                                            <div class="check"><div class="inside"></div></div>
                                                        </li>

                                                        <li>
                                                            <input type="radio" id="t-option" name="profession" value="unemployed" <?php echo ($assesmentData['profession'] == 'unemployed') ? 'checked="checked"' : ""; ?>>
                                                            <label for="t-option">Unemployed</label>

                                                            <div class="check"><div class="inside"></div></div>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="chose-option">
                                                    <h4>I am looking to...</h4>
                                                    <ul>
                                                        <li>
                                                            <input type="radio" id="x-option" name="looking_to" value="student" <?php echo ($assesmentData['looking_to'] == 'student') ? 'checked="checked"' : ""; ?>>
                                                            <label for="x-option">A student</label>

                                                            <div class="check"></div>
                                                        </li>

                                                        <li>
                                                            <input type="radio" id="y-option" name="looking_to" value="professional" <?php echo ($assesmentData['looking_to'] == 'professional') ? 'checked="checked"' : ""; ?>>
                                                            <label for="y-option">A professional</label>

                                                            <div class="check"><div class="inside"></div></div>
                                                        </li>

                                                        <li>
                                                            <input type="radio" id="z-option" name="looking_to" value="unemployed" <?php echo ($assesmentData['looking_to'] == 'unemployed') ? 'checked="checked"' : ""; ?>>
                                                            <label for="z-option">Unemployed</label>

                                                            <div class="check"><div class="inside"></div></div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col-sm-9 profile-image-container">
                                                <div class="profile-image">
                                                    <label>Profile Image</label>
                                                    <!--<form method="post" name="image-crop" action="<?php //echo base_url('Profile/save_profile_image');   ?>" enctype="multipart/form-data">-->
                                                    <input type="hidden" id="x" name="x" />
                                                    <input type="hidden" id="y" name="y" />
                                                    <input type="hidden" id="w" name="w" />
                                                    <input type="hidden" id="h" name="h" />
                                                    <input type="hidden" id="user" name="user" value="<?php echo $curUser['user_id'] ?>" />
                                                    <input type="hidden" id="profilesrc" name="profilesrc" value="" />
                                                    <div class="myProfileImage" style="display:none;"><img id="myProfileImage" alt=""></div>
                                                    <div class="clearfix"></div>
                                                    <input id="filesToUploadP" name="filesToUploadP" class="form-control" type="file">
                                                    <!--</form>-->
                                                </div>
                                                <?php if (isset($assesmentData['profile_image'])) { ?>

                                                    <div id="current-profile-image" class="float-right">
                                                        <label>Current Profile Image</label><div class="clearfix"></div>
                                                        <img src="<?php echo base_url(); ?>assets/images/profile_images/<?php echo $assesmentData['profile_image']; ?>" alt=""/>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>

                                        <div class="clearfix"></div>

                                        <div class="asses-btn">
                                            <?php if ($assesment == 0) { ?>
                                                <div><a  href="<?php echo base_url('Logout'); ?>"><button type="button">Logout</button></a></div>
                                            <?php } ?>
                                            <button type="submit">Submit</button>
                                            <div class="clear"></div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
//        $('#state').change(function(){alert('how');});
        $('#assesment-form').validate({
            igonore: [],
            rules: {
                state: 'required',
                city: 'required',
                zip: 'required',
                interest: 'required',
                dob: 'required',
                profession: 'required',
                looking_to: 'required',

            },
            messages: {
                state: 'State is required',
                city: 'City is required',
                zip: 'Zip code is required',
                interest: 'This field is required',
                dob: 'Please insert Date of birth',
                profession: 'Please select an option',
                looking_to: 'Please select an option'
            },
            errorPlacement: function (error, element) {
                if (element.attr('name') == 'profession' || element.attr('name') == 'looking_to') {
                    error.insertAfter(element.parents('ul'));
                } else {
//console.log(element.attr('name'));
                    error.insertAfter(element);

                }
            }


        });



        $('#dob').datepicker({
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+0"
        });


        $('#state').on('change', function (e) {
            var state = $(this).val();
//            console.log(state);
            $.ajax({
                type: 'POST',
                url: window.base_url + 'Profile/getCities',
                data: 'state=' + state,
                success: function (callBack) {
                    var data = $.parseJSON(callBack);
                    var citiesList = '';
                    $.each(data, function (key, val) {
                        var selected = '';
                        if (val.id == "<?php echo $assesmentData['city']; ?>") {
                            selected = 'selected="selected"';
                        }
                        citiesList += '<option value="' + val.id + '" ' + selected + '>' + val.name + '</option>';
                    });
                    $('#city').html(citiesList);
//                    console.log(temp);
                }
            });

        }).trigger('change');

        $('#city').on('change', function (e) {

            var state = $('#state option:selected').text();
            var city = $("#city option:selected").text();

            $.ajax({
                type: 'POST',
                url: window.base_url + 'Profile/getZipCode',
                data: 'state=' + state + 'city=' + city,
                beforeSend: function () {
                    $('#zip').val('');
                    $('#zip-preloader').removeClass('hidden');
                },
                success: function (callBack) {
                    var data = $.parseJSON(callBack);
//                    console.log(data);
                    $('#zip-preloader').addClass('hidden');
                    if (data.zip == null) {
                        $('#zip').attr('placeholder', 'Please type zip');
                    }
                    $('#zip').val(data.zip);
                }
            });

        })

    })
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jcrop/js/jquery.Jcrop.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jcrop/js/jquery.ajaxfileupload.js"></script>

<script>
    $("#filesToUploadP").AjaxFileUpload({

        action: '<?php echo base_url(); ?>Profile/profile_image',
        onComplete: function (filename, response) {
            $("#myProfileImage").attr('src', response.name);
            $(".myProfileImage").show();
            $("#current-profile-image").remove();
            $("#profilesrc").val(response.name);
            $('#myProfileImage').Jcrop({
                aspectRatio: 0.72,
                setSelect: [25, 40, 500, 254],
                onSelect: updateCoords
            });
        }
    });

    function updateCoords(c)
    {
        $('#x').val(c.x);
        $('#y').val(c.y);
        $('#w').val(c.w);
        $('#h').val(c.h);
    }

</script>
