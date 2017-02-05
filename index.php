<?php
require_once 'config.php';
include 'header.php';

/*******PAGINATION CODE STARTS*****************/
if (!(isset($_GET['pagenum']))) {
    $pagenum = 1;
} else {
    $pagenum = $_GET['pagenum'];
}
$page_limit = ($_GET["show"] <> "" && is_numeric($_GET["show"])) ? $_GET["show"] : 10;
try {
    $keyword = trim($_GET["keyword"]);
    if ($keyword <> "") {
        $sql  = "SELECT * FROM tbl_contacts WHERE 1 AND " . " (first_name LIKE :keyword) ORDER BY first_name ";
        $stmt = $DB->prepare($sql);
        $stmt->bindValue(":keyword", $keyword . "%");
    } else {
        $sql  = "SELECT * FROM tbl_contacts WHERE 1 ORDER BY first_name ";
        $stmt = $DB->prepare($sql);
    }
    $stmt->execute();
    $total_count = count($stmt->fetchAll());
    $last        = ceil($total_count / $page_limit);
    if ($pagenum < 1) {
        $pagenum = 1;
    } elseif ($pagenum > $last) {
        $pagenum = $last;
    }
    $lower_limit = ($pagenum - 1) * $page_limit;
    $lower_limit = ($lower_limit < 0) ? 0 : $lower_limit;
    $sql2        = $sql . " limit " . ($lower_limit) . " , " . ($page_limit) . " ";
    $stmt        = $DB->prepare($sql2);
    if ($keyword <> "") {
        $stmt->bindValue(":keyword", $keyword . "%");
    }
    $stmt->execute();
    $results = $stmt->fetchAll();
}
catch (Exception $ex) {
    echo $ex->getMessage();
}
/*******PAGINATION CODE ENDS*****************/

?>
    <div class="row">
      <?php if ($ERROR_MSG <> "") { ?>
      <div class="rounded alert alert-dismissable alert-<?php echo $ERROR_TYPE ?>">
        <button data-dismiss="alert" class="close" type="button">×</button>
        <p>
          <?php echo $ERROR_MSG; ?>
        </p>
      </div>
      <?php } ?>
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title" >Contact List</h3>
        </div>
        <div class="panel-body">
          <div class="col-lg-12" style="padding-left: 0; padding-right: 0;">
            <form action="index.php" method="get">
              <div class="col-lg-6 pull-left" style="padding-left: 0;">
                <span class="pull-left" id="search-bar">
                    <label class="col-lg-12 control-label" for="keyword" style="padding-right: 0;">
                        <input type="text" value="<?php echo $_GET["keyword"]; ?>" placeholder="search by first name" id="search" class="form-control" name="keyword">
                    </label>
                </span>
                <button class="btn btn-info" id="search-button" style="border-top-right-radius: 4px; border-bottom-right-radius: 4px;">search</button>
              </div>
            </form>
            <div class="pull-right"><a href="book.php" id="addcontact"><button class="btn btn-success rounded"><span class="glyphicon glyphicon-user"></span> Add New Contact</button></a></div>
          </div>
          <div class="clearfix"></div>
          <?php if (count($results) > 0) { ?>
          <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered ">
              <tbody>
                <tr>
                  <th>Avatar</th>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th class="hidden-xs hidden-sm">Contact No #1 </th>
                  <th class="hidden-xs hidden-sm">Email </th>
                  <th>Action </th>
                </tr>
                <?php foreach ($results as $res) { ?>
                <tr>
                  <td style="text-align: center;">
                    <?php $pic = ($res["profile_pic"] <> "" ) ? $res["profile_pic"] : "no_avatar.png" ?>
                    <a href="profile_pics/ <?php echo $pic ?>" target="_blank" ><img src="profile_pics/<?php echo $pic ?>" alt="" class="btn-circle"></a>
                  </td>
                  <td>
                    <?php echo $res["first_name"]; ?>
                  </td>
                  <td>
                    <?php echo $res["last_name"]; ?>
                  </td>
                  <td class="hidden-xs hidden-sm">
                    <?php echo $res["contact_no1"]; ?>
                  </td>
                  <td class="hidden-xs hidden-sm">
                    <?php echo $res["email_address"]; ?>
                  </td>
                  <td>
                    <a href="view.php?cid=<?php echo $res["contact_id"]; ?>">
                       <button class="btn btn-sm btn-info rounded">
                            <span class="glyphicon glyphicon-zoom-in" title="View"></span>
                            <span class="hidden-xs hidden-sm"> View</span>
                        </button>
                    </a>&nbsp;

                    <a href="book.php?m=update&cid=<?php echo $res["contact_id"]; ?>&pagenum=<?php echo $_GET["pagenum"]; ?>">
                        <button class="btn btn-sm btn-warning rounded">
                            <span class="glyphicon glyphicon-edit" title="Edit"></span>
                            <span class="hidden-xs hidden-sm"> Edit</span>
                        </button>
                    </a>&nbsp;

                    <a href="process_form.php?mode=delete&cid=<?php echo $res["contact_id"]; ?>&keyword=<?php echo $_GET["keyword"]; ?>&pagenum=<?php echo $_GET["pagenum"]; ?>" onclick="return confirm('Are you sure?')">
                        <button class="btn btn-sm btn-danger rounded">
                            <span class="glyphicon glyphicon-remove-circle" title="Delete"></span>
                            <span class="hidden-xs hidden-sm"> Delete</span>
                        </button>
                    </a>&nbsp;
                  </td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
          <div class="text-center">
              <div class="col-lg-12 center">
                <ul class="pagination">
                    <li>
                      <a href="index.php?pagenum=<?php echo $i; ?>&keyword=<?php echo $_GET["keyword"]; ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                      </a>
                    </li>
                    <?php
                    //Show page links
                    for ($i = 1; $i <= $last; $i++) {
                        if ($i == $pagenum) {
                    ?>
                    <li class="active">
                      <a href="javascript:void(0);">
                        <?php echo $i ?>
                      </a>
                    </li>
                    <?php
                    } else {
                    ?>
                    <li>
                        <a href="index.php?pagenum=<?php echo $i; ?>&keyword=<?php echo $_GET["keyword"]; ?>" 
                        class="links" onclick="displayRecords('<?php echo $page_limit; ?>', '<?php echo $i; ?>');">
                        <?php echo $i ?>
                        </a>
                    </li>
                    <?php
                        }
                    }
                    ?>
                    <li>
                      <a href="index.php?pagenum=<?php echo $i; ?>&keyword=<?php echo $_GET["keyword"]; ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                      </a>
                    </li>
                </ul>
              </div>
            </div>
            <?php } else { ?>
            <div class="well well-lg">No contacts found.</div>
            <?php } ?>
        </div>
      </div>
    </div>
</div> <!--page-wrap div located in header.php closing tag-->
<?php
include 'footer.php';
?> 