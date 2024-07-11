<style>
    .row.subscribtion {
        display: flex;
        justify-content: space-evenly;
        align-items: baseline;
    }
</style>
<div class="modal fade" id="allocate">
    <div class="modal-dialog modal-s">


        <div class="modal-content">
            <form action="{{route('payment.store')}}" method="POST" id="create_form" enctype="multipart/form-data">
                @csrf

                <div class="modal-header mh">
                    <h4 class="modal-title">Allocate window</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body" style=" background-color: #f8fffb;">
                    <input type="hidden" class="form-control" required id="user_id" name="user_id" value="">
                    <input type="hidden" class="form-control" required id="user_details" name="user_details" value="eligibleq">
                    <div class="row">
                        <label class="col-sm-4" style="font-size: 16px !important; color:DarkSlateBlue;">Name<span class="error-star" style="color:red;">*</span></label>

                        <input class="form-control col-sm-8" style="font-size: 16px !important; color:DarkSlateBlue;" name="name" id="name">
                    </div>
                    <div class="row">
                        <label class="col-sm-4" style="font-size: 16px !important; color:DarkSlateBlue;">Choose Plan<span class="error-star" style="color:red;">*</span></label>
                    </div>
                    <div class="row subscribtion">
                        <label style="font-size: 16px !important; color:DarkSlateBlue;">
                            <input type="radio" name="exampleRadios" id="exampleRadios1" value="3 months" checked>
                            3 Months Plan
                        </label>
                        <label style="font-size: 16px !important; color:DarkSlateBlue;">
                            <input type="radio" name="exampleRadios" id="exampleRadios1" value="6 months">
                            6 Months Plan
                        </label>
                        <label style="font-size: 16px !important; color:DarkSlateBlue;">
                            <input type="radio" name="exampleRadios" id="exampleRadios1" value="12 months">
                            12 Months Plan
                        </label>
                    </div>
                    <div class="row">
                        <label class="col-sm-4" style="font-size: 16px !important; color:DarkSlateBlue;"> Subscription Amount</label>
                        <input class="form-control col-sm-8" style="font-size: 16px !important; color:DarkSlateBlue;" name="p_name" value="359 INR" id="p_price" readonly>
                    </div>


                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <input type="hidden" class="form-control col-sm-8" style="font-size: 16px !important; color:DarkSlateBlue;" name="ren_date" id="ren_date" readonly>

                            <button type="submit" class="btn btn-success btn-space" id="savebutton">Pay</button>
                            <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">


                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
<script type="application/javascript">
    const element = document.getElementsByName("exampleRadios");

    element[0].addEventListener("click", function(e) {
        const d = new Date();
        document.getElementById("p_price").value = "359 INR";
        d.setMonth(d.getMonth() + 3);
        document.getElementById("ren_date").value = d.toLocaleDateString('zh-Hans-CN');
    });
    element[1].addEventListener("click", function(e) {
        const d = new Date();
        document.getElementById("p_price").value = "699 INR";
        d.setMonth(d.getMonth() + 6);
        document.getElementById("ren_date").value = d.toLocaleDateString('zh-Hans-CN');
    });
    element[2].addEventListener("click", function(e) {
        const d = new Date();
        document.getElementById("p_price").value = "1299 INR";
        d.setMonth(d.getMonth() + 12);
        document.getElementById("ren_date").value = d.toLocaleDateString('zh-Hans-CN');
    });
</script>