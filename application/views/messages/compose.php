<!--Content-->
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="profile">
                        <!--left menu-->


                        <div class="col-md-9 col-sm-8">
                            <div class="row">
                                <div class="profile-cont">
                                    
                                    <?php $this->load->helper('url'); ?>


                                    <?php
                                    /*
                                     * Note:
                                     * 'name' is the "name" property of the input field / list
                                     * 'id' is the "id" property of the input field / list AND the "for" property of the label field
                                     * 'name' and 'id' dont have to be the same - but it is most logical
                                     */
                                    $this->load->library('session');
                                    $MAX_INPUT_LENGTHS = $this->config->item('$MAX_INPUT_LENGTHS', 'pm');
                                    $recipients = array(
                                        'name' => PM_RECIPIENTS,
                                        'id' => PM_RECIPIENTS,
                                        'value' => set_value(PM_RECIPIENTS, $message[PM_RECIPIENTS]),
                                        'maxlength' => $MAX_INPUT_LENGTHS[PM_RECIPIENTS],
                                        'size' => 40,
                                    );
                                    $subject = array(
                                        'name' => TF_PM_SUBJECT,
                                        'id' => TF_PM_SUBJECT,
                                        'value' => set_value(TF_PM_SUBJECT, $message[TF_PM_SUBJECT]),
                                        'maxlength' => $MAX_INPUT_LENGTHS[TF_PM_SUBJECT],
                                        'size' => 40
                                    );
                                    $body = array(
                                        'name' => TF_PM_BODY,
                                        'id' => TF_PM_BODY,
                                        'value' => set_value(TF_PM_BODY, $message[TF_PM_BODY]),
                                        'cols' => 80,
                                        'rows' => 5
                                    );
                                    ?>
                                    <?php echo form_open($this->uri->uri_string()); ?>
                                    <div class="form-group col-sm-7">
                                        <?php
                                        echo form_label('To', $recipients['id']);

                                        $recipients = array('name' => 'recipients', 'id' => 'recipients', 'class' => 'form-control col-sm-5', 'placeholder' => 'Enter email');
                                        echo form_input($recipients);

                                        echo form_error($recipients['name'], '<div class="error">', '</div>');
                                        ?>
                                    </div>
                                    <div class="clearfix"></div>

<!--                                    <div class="form-group col-sm-7">
                                        <?php
//                                        echo form_label('Subject', $subject['id']);
//
//                                        $subject = array('name' => 'privmsg_subject', 'id' => 'privmsg_subject', 'class' => 'form-control col-sm-5', 'placeholder' => 'Subject');
//                                        echo form_input($subject);
//                                        echo form_error($subject['name'], '<div class="error">', '</div>');
                                        ?>
                                    </div>-->
                                    <div class="clearfix"></div>

                                    <div class="form-group  col-sm-7">
                                        <?php
                                        echo form_label('Message', $body['id']);
                                        $body = array('name' => 'privmsg_body', 'id' => 'privmsg_body', 'class' => 'form-control');
                                        echo form_textarea($body);
                                        echo form_error($body['name'], '<div class="error">', '</div>');
                                        ?>
                                    </div>

                                    <div>
                                        <?php
                                        if (isset($status))
                                            echo $status.' ';
                                        if ($this->session->flashdata('status'))
                                            echo $this->session->flashdata('status').' ';
                                        if (!$found_recipients) {
                                            foreach ($suggestions as $original => $suggestion) {
                                                echo 'Did you mean <font color="#00CC00">'.$suggestion.'</font> for <font color="#CC0000">'.$original.'</font> ?';
                                                echo '<br />';
                                            }
                                        }
                                        ?>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="form-group">
                                        
                                    <input class="btn col-sm-5 col-sm-offset-1 btn-success" type="submit" name="btnSend" id="btnSend" value="Send" />
                                    </div>
                                    <?php echo form_close(); ?>


                                    <?php /* echo form_open($this->uri->uri_string()); ?>


                                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                        <tr class=" form-group">
                                            <td class="col-sm-2"><?php echo form_label('To', $recipients['id']); ?></td>
                                            <td class="col-sm-5 form-control"><?php echo form_input($recipients); ?></td>
                                        </tr>	
                                        <tr>
                                            <td class="col-sm-2"></td>
                                            <td class="error col-sm-10"><?php echo form_error($recipients['name']); ?></td>	
                                        </tr>	
                                        <tr>
                                            <td class="col-sm-2"><?php echo form_label('Subject', $subject['id']); ?></td>
                                            <td class=" error col-sm-10"><?php echo form_input($subject); ?></td>
                                        </tr>
                                        <tr>
                                            <td class="col-sm-2"></td>
                                            <td class="error col-sm-10"><?php echo form_error($subject['name']); ?></td>	
                                        </tr>	
                                        <tr>
                                            <td class="col-sm-2"><?php echo form_label('Message', $body['id']); ?></td>
                                            <td class="col-sm-10"><?php echo form_textarea($body); ?></td>
                                        </tr>
                                        <tr>
                                            <td class="col-sm-2"></td>
                                            <td class="error col-sm-10"><?php echo form_error($body['name']); ?></td>	
                                        </tr>
                                        <tr>
                                            <td class="col-sm-2"></td>
                                            <td class="col-sm-10">
                                                <!-- DO NOT CHANGE BUTTON NAME, NEEDED FOR CONTROLLER "send" -->
                                                <input class="btn col-sm-5 btn-success" type="submit" name="btnSend" id="btnSend" value="Send" />
                                            </td>
                                        </tr>	
                                        <tr>
                                            <td align="left" valign="top" style="font-weight:bold; padding:4px;">
                                                <?php
                                                if (isset($status))
                                                    echo $status.' ';
                                                if ($this->session->flashdata('status'))
                                                    echo $this->session->flashdata('status').' ';
                                                if (!$found_recipients) {
                                                    foreach ($suggestions as $original => $suggestion) {
                                                        echo 'Did you mean <font color="#00CC00">'.$suggestion.'</font> for <font color="#CC0000">'.$original.'</font> ?';
                                                        echo '<br />';
                                                    }
                                                }
                                                ?>
                                            </td>
                                            <td></td>
                                        </tr>
                                    </table>
                                    <?php echo form_close(); */?>



                                </div>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
        </div>	
    </div>
</div>


<script>
     $(document).on('keyup', '#recipients', function (e) {
            var input = $(this).val();
//            console.log(input.substr(input.indexOf("@") + 1));
            
                $("#recipients").autocomplete({
                    source: function (request, response) {

                        $.ajax({
                            url: window.base_url + 'Users/search_user',
                            dataType: "json",
                            data: {
                                value: input.substr(input.indexOf("@") + 1)
                            },
                            success: function (data) {
                                response(data);
                            }
                        });
                    },
                    minLength: 2,
                    select: function (event, ui) {
                        event.preventDefault();
                        $('#recipients').val(ui.item.value);
                    }
                });
            
        });
        
        </script>





