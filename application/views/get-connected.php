<?php
$this->load->helper('date');
 $curUser = currentuser_session();?>
<div class="center-content">


                            <div class="connect-title">
                                <h5>Let your <span>DREAM LIGHT</span> shine bright so that other  <span>DREAMERS</span>  can connect with you</h5>
                            </div>
                            <div  id="map" style="height:300px;"></div>

                            <div id="tabs" class="tabs-inline">
                                <ul class="list-inline nav-tabs">
                                    <li><a href="#recent-activities" role="tab" data-toggle="tab">Recent Activities</a></li>
                                    <li><a href="#Connections">Connections</a></li>
                                    
                                   
                                </ul>
                                <!-- Tab panes -->
                                    
                                    <div id="recent-activities">
                                     
                                    <div class="conection-profile">
                                    
                                     <?php foreach ($recentActivities as $ra) { ?>
                                     <div class="conection-box">
                                     	<div class="conection-image">
			                                        <a href="<?php echo base_url("Posts/view_post?id=".$ra['post_id']); ?>"><img class="img-pp" width="120px" height="121px" src="<?php echo base_url(); ?>assets/images/profile_images/<?php echo ($ra['profile_image']) ? $ra['profile_image'] : 'dummy-img.png'; ?>" alt="" title=""></a>
			                                    </div>
			                                    <div class="conection-name"><?php echo substr($ra['first_name'], 0, 10); ?></div>
                                      </div>
                                    <?php } ?>
                                    </div>
                                    </div>
                                    <div id="Connections">
                                    
                                   
                                    	
                                    
                                    	<div class="conection-profile">
                                        
                                        	<?php
                                             if ($users) {
                                        	 foreach ($users as $user_info) {?>
			                                <div class="conection-box">
			                                    <div class="conection-image">
			                                        <img class="img-pp" width="120px" height="121px" src="<?php echo $img = (!empty($user_info['profile_image'])) ? base_url()."assets/images/profile_images/".$user_info['profile_image'] : base_url()."assets/images/profile_images/dummy-img.png" ?>" alt="" title="">
			                                    </div>
			                                    <div class="conection-name"><?php echo $user_info['first_name'].' '.$user_info['last_name']; ?></div>
			                                    <a href="<?php echo base_url()?>pm/send/<?php echo $user_info['user_id']; ?>" class="message-btn">Send Message</a>
			                                </div>
                                            
                                            <?php } }else{?>
                                            <div class="conection-box">
			                                    <span>Friend List is empty</span>
			                                </div>
                                            <?php }?>
			                               
			                            </div>
                                    </div>
                               
                            </div>
                            
                        </div>



<script type="text/javascript">
    function initMap() {

		console.log('here');
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 4,
            center: new google.maps.LatLng(41.850033, -87.6500523),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        var infowindow = new google.maps.InfoWindow();

        var marker, i;

        $.getJSON('<?php echo base_url(); ?>Users/markers', function (data) {
//                                console.log(data);
            $.each(data.markers, function (i, user) {
//                console.log(user);
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(user.latitude, user.longitude),
                    map: map
                });

                google.maps.event.addListener(marker, 'click', (function (marker, i) {
                    return function () {
                        var img = '<img width="25px" src="'+window.base_url+'assets/images/profile_images/'+user.image+'" alt=""/>'
                        infowindow.setContent('<a href="'+window.base_url+'profile/user_profile/'+user.id+'">'+img+" "+user.name+'</a>');
                        infowindow.open(map, marker);
                    }
                })(marker, i));
            });
        });


    }
</script>

<script async defer
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAzgQTfcr-EOLOPFmVFxlp467KAw3LoTPo&callback=initMap"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/map/jquery.ui.map.js"></script>

