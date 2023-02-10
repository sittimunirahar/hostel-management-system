<?php
include 'upperbody.php';
if (!empty($_SESSION['password']) && !empty($_SESSION['username'])) {
?>
  <div class="list-group">
    <a href="index.php" class="list-group-item active">Hostel Management</a>
    <a href="allocation.php" class="list-group-item ">Hostel Allocation</a>
    <a href="payment.php" class="list-group-item">Manage Payment</a>
    <a href="services.php" class="list-group-item">Services</a>
  </div>

  </div>

  <div class="tabs">
    <ul class="nav nav-tabs nav-justified">
      <li><a href="mgt-hostelunit.php">Hostel Unit</a></li>
      <li class="active"><a href="mgt-unitowner.php">Unit Owner</a></li>
      <li><a href="mgt-occup.php">Occupants</a></li>
      <li><a href="mgt-fees.php">Fees</a></li>
    </ul>
  </div>

  <div class="content">
    <form action="editowner.php" method="get">
      <br>

      <h3>Edit Owner Information</h3>
      <hr>

      Unit Number: <input name="unitno" type="text" id="unitno" value="B-15-08"></td>
      </tr>
      <br></p>
      Owner Name: <input name="ownername" type="text" id="ownername" value="HOW CHEE HENG"></td>
      </tr>
      <br></p>
      Expired Date: <input name="expdate" type="text" id="expdate" value="30-Sep-16"></td>
      </tr>
      <br></p>
      Email: <input name="email" type="text" id="email" value="chrishow@hotmail.com"></td>
      </tr>
      <br></p>
      Phone No: <input name="pno" type="text" id="pno" value="011-1234567"></td>
      </tr>
      <br></p>
      Remarks: <input name="remarks" type="text" id="remarks" value="change expired date and phone no"></td>
      </tr>
      <br></p>
    </form>
    <div class="edit-option">
      <p>
        <br>
        <input name="ok" type="button" value="OK" class="btn btn-primary" onClick="document.location.href=('mgt-unitowner.php');" />
        <input name="clear" type="button" value="Clear" class="btn btn-primary" />
      </p>
    </div>
  </div>
<?php
  include 'lowerbody.php';
} else {
  require 'warninglogin.php';
} ?>