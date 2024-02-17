   function addMore1() {
														var data='<tr><td><select class="form-control" name="label[]" > <option value="Flavour">Flavour</option> <option value="Protein">Protein</option> <option value="Servings">Servings</option> <option value="Serving Size">Serving Size</option> <option value="Servings Per Container">Servings Per Container</option> <option value="Weight">Weight</option> <option value="Form">Form</option> </select></td><td><input class="form-control" type="text" placeholder="Value" name="value[]" data-bvalidator="required"/></td> <td><a href="javascript:void(0);" class="remove"><span class="glyphicon glyphicon-remove"></span></a></td></tr>';
                                                           $("#tb").append(data);
                                                           

                                                        }
                                                        
   $(document).on('click', '.remove', function () {
                                                                var trIndex = $(this).closest("tr").index();
                                                                if (trIndex > 1) {
                                                                    $(this).closest("tr").remove();
                                                                } else {
                                                                    alert("Sorry!! Can't remove first row!");
                                                                }
                                                            });
function addimageselect(divid,arrayname){
    $("#"+divid).append('<input type="file" name="'+arrayname+'[]" /><a href="javascript:void(0);" class="removeimage"><span class="glyphicon glyphicon-remove"></span></a>');
} 

function addsection(divid,type){
    $("#"+divid).append('<li><div class="row"><div class="col-md-4 col-sm-4"><input class="form-control input-lg" name="names[]" type="text" /></div><div class="col-md-4 col-sm-4"><input type="file" name="images[]" /></div><div class="col-md-3 col-sm-3"><textarea class="form-control textarea input-lg" name="descriptions[]" ></textarea><input type="hidden" name="type[]" value="'+type+'" /></div><div class="col-md-1 col-sm-1"><a href="javascript:void(0);" class="removeimage"><span class="glyphicon glyphicon-remove"></span></a></div></div></li>');
}


$(document).on('click', '.removeimage', function () {

  
   $(this).closest("li").remove();
   
                                                            });
   function generatebarcode(){
	$.get('generatebarcode.php',function(dat){
		$('#barcode').val(dat);
		
	});
}
function refreshcheckoutwithflag(){
    window.location.replace("http://www.buyceps.com/checkout.php?flag=1");
}
 function reloadfields(){
    
   var i=1;
   var strin='';
        $("input:checkbox[class=chk]:checked").each(function () {
            if(i>1){
                strin = strin + ',';
            }
            
            strin = strin + $(this).val();
            i++;
        });
        
        view(strin, "customfields", "fetchfields.php", "fetching");
        
   

    }
function createslug(orgid,desid){
   var newslug= $("#"+orgid).val().replace(/ /gi,"-");
   $("#"+desid).val(newslug);
}
function changeexpiry(id){
    var mfgdate=$("#mfg_"+id).val();
    var now = new Date(mfgdate);
        // console.log(now);
        var expiryMonth=$("#expire_"+id).val();
        if(expiryMonth==0){
            $('#expiry_'+id).val(mfgdate);
        }
        else{
            var expDate = now.setDate(now.getDate() + (expiryMonth*30));
         expDate = new Date(expDate);
         var day = ("0" + expDate.getDate()).slice(-2);
var month = ("0" + (expDate.getMonth() + 1)).slice(-2);


         var finalExpdate = expDate.getFullYear()+"-"+(month)+"-"+(day);
    //var finalExpdate= new Date(expDate);     
    
         $('#expiry_'+id).val(expDate);
        }

    
    
}
function changemanu(id){
    var mfgdate=$('#expiry_'+id).val();
   
         $('#mfg_'+id).val(mfgdate);
    
    
}
function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}
function choosestars(thecount){
    var i=1;
    $("#stars").html();
    for(i=1;i<thecount;i++){
        $("#stars").append('<span class= "star" onclick="choosestars('+i+')"></span>');
    }
    for(i=thecount;i<5;i++){
         $("#stars").append('<span onclick="choosestars('+i+')"></span>');
    }
}
function bringfieldgenre(cat,res1,res2){
   view(cat,res1,'fetchgenre.php','fetching'); 
   view(cat,res2,'fetchfields.php','fetching'); 
}
function updatecart(itemid,rowid){
   var itemqty= $("#"+rowid).val();

   view(itemid, 'carttbody', 'updatecart.php', itemqty);
}
function removefromcart(itemid){
   var what="Hakuna Matata";

   view(itemid, 'carttbody', 'removecart.php', what);
   
}
function removefromwishlist(itemid){
   var what="Hakuna Matata";

   view(itemid, 'wishlist', 'removewishlist.php', what);
   
}
function removefromwishlistpage(itemid){
   var what="Hakuna Matata";

   view(itemid, 'wishlistpage', 'removewishlist.php', 'page');
   
}
function refreshflavour(){
    search('flovours','flovours','fetchflavours.php','fetching');
}

function refreshtag(){
    search('flovours','flovours','fetchtag.php','fetching');
}

function refreshgenre(){
    search('flovours','flovours','fetchgenre.php','fetching');
}
function refreshtrailer(){
    view('flovours','catid','fetchtrailers.php','fetching');
}
function refreshfield(){
    search('flovours','flovours','fetchfield.php','fetching');
}
function refreshreviewfield(){
    search('flovours','flovours','fetchreviewfield.php','fetching');
}

function refreshcustomers(){
    search('customer','customer','fetchcustomers.php','fetching');
    $('#closemodal').click();
}

function refreshweight(){
    search('wots','wots','fetchweight.php','fetching');
}
function refreshconcat(){
    search('wots','wots','fetchconcat.php','fetching');
}
function generatevariations(opt1,opt2,rid){
    var val1=$("#"+opt1).val();
    var val2=$("#"+opt2).val();
    view(val1, rid, 'generatevariations.php', val2);
    
}
function dataTableInitiate(){
    if($("#example1").length>0){
        $('#example1')
    .on( 'init.dt', function () {
        console.log( 'Table initialisation complete: '+new Date().getTime() );
    } )
    .dataTable();
    }
    
    
}
function fetchflavour(){
    view(1, 'catid', 'fflavour.php', 'fetch');
    
}

function fetchtag(){
    view(1, 'catid', 'ftag.php', 'fetch');
    
}
function fetchgenre(){
    view(1, 'catid', 'fgenre.php', 'fetch');
    
}
function fetchfield(){
    view(1, 'catid', 'ffield.php', 'fetch');
    
}
function fetcreviewhfield(){
    view(1, 'catid', 'frfield.php', 'fetch');
    
}
function fetchreviewfield(){
    view(1, 'catid', 'freviewfield.php', 'fetch');
    
}
function fetchrquestions(){
    view(1, 'catid', 'fquestions.php', 'fetch');
    
}
function fetchweight(){
    view(1, 'catid', 'fweight.php', 'fetch');
    
}
function fetchconcat(){
    view(1, 'catid', 'fconcat.php', 'fetch');
    
}
function selectswitch(){
   $("#selectall").click(function(){
    $('input:checkbox').not(this).prop('checked', this.checked);
});
 $("#selectall2").click(function(){
    $('input:checkbox').not(this).prop('checked', this.checked);
});
}
function loadflavour(fid,mainproduct){
    view(fid,"resultid","fetchflavour.php",mainproduct);
}
function removeimages(removeid,fieldid){
    var allids=$("#"+fieldid).val();
    allids=allids.replace(removeid,"");
    allids=allids.replace(",,",",");
    $("#"+fieldid).val(allids);
    $("#im"+removeid).remove();
}
function updaterange(value,divid){
    $("#"+divid).html("₹"+value);
}

