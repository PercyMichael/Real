<!DOCTYPE html>
<html lang="en">

<head>
    <title>Owners</title>
    <?php require('../../ui/obj_header.php') ?>
</head>

<body id="body-pd" style="background-color:#f8f9fa !important;">

    <header class="header" id="header">
        <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i> </div>
        <div class="header_img"> <img src="https://i.imgur.com/hczKIze.jpg" alt=""> </div>
    </header>
    <?php require('../../sidebar.php') ?>
    <!--Container Main start-->
    <div class="height-100 bg-light">
        <h4>Main Components</h4>


        <div class="table-wrapper mt-5" style="background: #fff;padding: 20px;box-shadow: 0 1px 1px rgb(0 0 0 / 5%);">


            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#add_owner"><i class="fa fa-plus" aria-hidden="true"></i> Add New</button>


            <table class="table  table-bordered table-hover mt-3 mx-auto ">
                <thead class="border-0">
                    <tr class="table-info">
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Units</th>
                        <th scope="col">Contact</th>
                        <th scope="col">NIN</th>
                        <th scope="col">Bank A/C</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody id="owners">

                </tbody>
            </table>
        </div>
    </div>



    <?php
    require("../screens/modals.html");
    ?>
    <script>
        //buttons logic

        function displayOwners() {
            $.ajax({
                url: "../functions/get_owners.php",
                type: "POST",
                cache: false,
                success: function(data) {
                    $('#owners').html(data);
                }
            });
        }



        //delete owner
        $(document).on('click', '#deletebutton', function() {
            var name=$(this).val();
            var id = $(this).attr('data-id');
            if (confirm("Are sure you Want to delete " + name + "?! of id "+id) == true) {
                $.ajax({
                    url: '../functions/delete_owner.php',
                    type: 'post',
                    data: {
                        id: id
                    },
                    success: function() {
                        displayOwners();
                    }
                });
            }
        })

        var id;
        var name;
        var contact;
        var nin;
        var bank;
        $(document).ready(function() {
            $(document).on('click', '#updatebutton', function() {
                id = $(this).attr('data-id');
                name = $(this).attr('data-names');
                contact = $(this).attr('data-contact');
                nin = $(this).attr('data-nin');
                bank = $(this).attr('data-bank');

                $('#updateModal').modal('show');
                $('#ownerName').val(name);
                $('#ownerContact').val(contact);
                $('#ownerNin').val(nin);
                $('#ownerBank').val(bank);



            });

            $(document).on('click', '#realupdate', function() {
                $.ajax({
                    url: '../functions/update_owner.php',
                    type: 'post',
                    data: {
                        id: id,
                        name: $('#ownerName').val(),
                        contact: $('#ownerContact').val(),
                        nin: $('#ownerNin').val(),
                        bank: $('#ownerBank').val()
                    },
                    success: function(dataResult) {
                        var dataResult = JSON.parse(dataResult);
                        if (dataResult.statusCode == 200) {

                            alert(name + " Has been updated!");
                            displayOwners();
                        } else {
                            alert('error ');
                        }
                    }

                });

            });


        });

        function addOwners() {
            $('#addowner').click(
                function() {
                    $('#addowner').attr('disabled', 'disabled');
                    var names = $('#names').val();
                    var contact = $('#contact').val();
                    var nin = $('#nin').val();
                    var bank = $('#bank').val();

                    if (names != "" && contact != "" && nin != "" && bank != "") {
                        $.ajax({
                            url: "../functions/add_owner.php",
                            type: "POST",

                            data: {
                                names: names,
                                contact: contact,
                                nin: nin,
                                bank: bank
                            },

                            cache: false,
                            success: function(dataResult) {
                                var dataResult = JSON.parse(dataResult);
                                if (dataResult.statusCode == 200) {
                                    $("#addowner").removeAttr("disabled");
                                    alert(names + ' was sucessfully added as an owner!');
                                    //redisplay data
                                    displayOwners();
                                    $('#add_user_form').find(':input').val('');
                                } else if (dataResult.statusCode == 201) {
                                    alert("Error occured !");
                                }
                            }
                        });
                    } else {
                        alert('Please fill all the fields!');
                        $("#addowner").removeAttr("disabled");
                    }
                }
            );
        }
    </script>





</body>

</html>