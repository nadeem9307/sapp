<?php
include_once 'menuplan.inc.php';
include_once 'header.php';
?>
<div class="content-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h4 class="page-head-line">Menu Plans</h4>

            </div>

        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-warning">
                    Admin can manage menu plans here.
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading form_heading" >

                    </div>
                    <div class="panel-body">
                        <form name="add_meal_plan"  id="add_meal_plan"  method="post">

                            <div class="form-group">
                                <label for="exampleInputEmail1">Product Type</label>
                                <label for="sel1">Select list (select one):</label>
                                <select class="form-control shopify_product_list" id="shopify_product_id" name="shopify_product_id">
                                    <option value="">----Select Product----</option>
                                    <?php
                                    $id_name = array();
                                    $shop_json = get_product_type_shopify();
                                    foreach ($shop_json as $key => $array) {
                                            echo "<option value='" . $array['id'] . "," . $array['title'] . "'>" . $array['title'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="mealunit">Meal Unit's</label>
                                <input type="number" class="form-control" id="m_units" name="m_units" placeholder="units" required="true">
                            </div>
                            <input type="button" name="add" value="Save Plan" class="btn btn-primary add_meal">
                            <input type="text" name="action" value="add_meal_paln" hidden="true">
                        </form>
                        <div class="msg">

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Meal database
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive output_menu_plans">
                            <?php
                            echo "<table class='table table-striped table-bordered table-hover menu_database'>";
                            echo "<thead><tr>";
                            echo "<th>Shopify Product ID.</th>";
                            echo "<th>Name</th>";
                            echo "<th>Meal Unit's</th>";
                            echo "<th>Action</th>";
                            echo "</tr><thead><tbody>";


                            if (!empty($result_table)) {
                                $i = 1;
                                while ($row = mysqli_fetch_array($result_table)) {
                                    echo "<tr class='" . $row['shopify_product_id'] . "'>";
                                    echo "<td>" . $row['shopify_product_id'] . "</td>";
                                    echo "<td>" . $row['meal_name'] . "</td>";
                                    echo "<td>" . $row['meal_units'] . "</td>";
                                    echo "<td>"
                                    . "<button name='edit' value='Edit' data-id='" . $row['shopify_product_id'] . "' data-mealname='" . $row['meal_name'] . "'  class='btn btn-primary btn-xs update_meal'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></button>"
                                    . "<button name='delete' value='Delete' data-id=" . $row['shopify_product_id']. " class='btn btn-primary btn-xs delete_meal'><i class='fa fa-trash-o' aria-hidden='true'></i></button></td>";
                                    echo "</tr>";
                                    $i++;
                                }
                            } else {
                                echo "<div class='empty'>No records matching  found.</div>";
                            }
                            echo "</tbody></table>";
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>    