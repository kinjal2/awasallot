<!DOCTYPE html>
<html>
@include(Config::get('app.theme').'.template.header_front_page')
<div class="container">
    <div class="row justify-content-center padd-y-50">
        <div class="col-md-6 mx-auto">
            <div class="card box-design">
                <div class="login-head text-center">
                    <p class="login-icon py-2">Check Vacant Quaters</p>
                    <h4 class="m-0"><b>E-State Management System</b></h4>
                    <p class="sub-title-form">Government of Gujarat</p>
                </div>

                <div class="card-body bg-lightwhite p-4">
                    <form method="POST" action="{{ route('ddo.login') }}" id="LoginForm" name="LoginForm">
                        @csrf

                        <div class="mb-3 form-group relative">
                            <label for="exampleSelect" class="form-label">Select City</label>
                            <select class="form-select" id="exampleSelect">
                                <option selected>Open this select menu</option>
                                <option value="1">Option 1</option>
                                <option value="2">Option 2</option>
                                <option value="3">Option 3</option>
                                <option value="4">Option 4</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="exampleSelect" class="form-label">Select Taluka</label>
                            <select class="form-select" id="exampleSelect">
                                <option selected>Open this select menu</option>
                                <option value="1">Option 1</option>
                                <option value="2">Option 2</option>
                                <option value="3">Option 3</option>
                                <option value="4">Option 4</option>
                            </select>
                        </div>


                        <div class="d-flex justify-content-between mt-5 my-2">
                            <button class="btn-new btn btn-primary btn-md" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <table class=" table table-bordered table-striped table-responsive-stack text-center mt-4">
                <thead class="cf">
                  <tr><th>અનુ.</th><th>વસવાટની કક્ષા</th><th class="numeric">સાતમા પગારપંચ મુજબ મુળ પગાર (રૂપિયા)</th></tr>
                </thead>
                <tbody>
                  <tr><td>૧</td><td>એ / જ-૧ / કક્ષા-૧</td><td>૧૪૮૦૦</td></tr>
                  <tr><td>૨</td><td>જ-ર</td><td>૧૮૦૦૦</td></tr>
                  <tr><td>૩</td><td>બી / જ / કક્ષા-ર</td>	<td>૧૯૯૦૦</td></tr>
                  <tr><td>૪</td><td>બી-૧ / છ</td>	<td>૨૫૫૦૦</td></tr>
                  <tr><td>૫</td><td>સી / ચ-૧</td>	<td>૨૯૨૦૦</td></tr>
                  <tr><td>૬</td><td>ચ / કક્ષા-૩</td>	<td>૩૯૯૦૦</td></tr>
                  <tr><td>૭</td><td>ડી / ઘ-૧</td>	<td>૫૩૧૦૦</td></tr>
                  <tr><td>૮</td><td>ડી-૧ / ઘ / કક્ષા-૪</td>	<td>૫૬૧૦૦</td></tr>
                  <tr><td>૯</td><td>ઇ / ગ-૧ / કક્ષા-પ</td>	<td>૭૮૮૦૦</td></tr>
                  <tr><td>૧૦</td>	<td>ઇ-૧ / ગ</td>	<td>૧૨૩૧૦૦</td></tr>
                  <tr><td>૧૧</td>	<td>ઇ-ર / ખ</td>	<td>૧૩૧૧૦૦</td></tr>
                  <tr><td>૧૨</td>	<td>‘ક‘ *</td>	<td>૧૪૪૨૦૦</td></tr>
                  <tr><td>૧૩</td>	<td>મંત્રીશ્રીઓના બંગલા</td>	<td>પગારધોરણ ધ્યાને લીધા સિવાય</td></tr>
                </tbody>
              </table>
    </div>
</div>
@include(Config::get('app.theme').'.template.footer_front_page')


