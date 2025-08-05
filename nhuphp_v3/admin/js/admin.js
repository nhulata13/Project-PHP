function checkAddProductNULL()
{
    var flag=true;
    var txtProductName = document.addProduct.atxtProductName.value;
    var txtBrandName = document.addProduct.atxtBrandName.value;
    var slcType = document.addProduct.aslcType.value;
    var slcGender = document.addProduct.aslcGender.value;
    var slcSize = document.addProduct.aslcSize.value;
    var txtPrice = document.addProduct.atxtPrice.value;
    var txtQuantity = document.addProduct.atxtQuantity.value;

    document.getElementById('lblProductNameNULL').style.display='none';
    document.getElementById('lblBrandNameNULL').style.display='none';
    document.getElementById('lblTypeNULL').style.display='none';
    document.getElementById('lblGenderNULL').style.display='none';
    document.getElementById('lblSizeNULL').style.display='none';
    document.getElementById('lblPriceNULL').style.display='none';
    document.getElementById('lblQuantityNULL').style.display='none';
    document.getElementById('lblTypeNULL').style.display='none';

    if(txtProductName.length==0)
        {document.getElementById('lblProductNameNULL').style.display='inline-block'; flag=false;}
    if(txtBrandName.length==0)
        {document.getElementById('lblBrandNameNULL').style.display='inline-block'; flag=false;}
    if(slcType.length==0)
        {document.getElementById('lblTypeNULL').style.display='inline-block'; flag=false;}
    if(slcGender.length==0)
        {document.getElementById('lblGenderNULL').style.display='inline-block'; flag=false;}
    if(slcSize.length==0)
        {document.getElementById('lblSizeNULL').style.display='inline-block'; flag=false;}
    if(txtPrice.length==0)
        {document.getElementById('lblPriceNULL').style.display='inline-block'; flag=false;}
    if(txtQuantity.length==0)
        {document.getElementById('lblQuantityNULL').style.display='inline-block'; flag=false;}
    if(!flag)
        document.getElementById('lblNULL').style.display='block';
    return flag;
}

function checkPrice()
{
    var txtPrice = document.addProduct.atxtPrice.value;
    if (!/^\d+$/.test(txtPrice))
    {
        document.getElementById('lblPriceNoError').style.display='inline-block';
        return false;
    }
    return true;
}

function checkQuantity()
{
    var txtQuantity = document.addProduct.atxtQuantity.value;
    if (!/^\d+$/.test(txtQuantity))
    {
        document.getElementById('lblQuantityNoError').style.display='inline-block';
        return false;
    }
    return true;
}

function checkAddProduct()
{
    flag=checkAddProductNULL();
    if(!checkPrice())
        flag=checkPrice();
    if(!checkQuantity())
        flag=checkQuantity();
    return flag;
}

function checkAddProductTypeNULL()
{
    var flag=true;
    var txtProductName = document.addProductType.ttxtProductName.value;
    var txtCategory = document.addProductType.ttxtCategory.value;
    var slcGender = document.addProductType.tslcGender.value;

    if(txtProductName.length==0)
        {document.getElementById('lblProductNameTypeNULL').style.display='inline-block'; flag=false;}
    if(txtCategory.length==0)
        {document.getElementById('lblCategoryNULL').style.display='inline-block'; flag=false;}
    if(slcGender.length==0)
        {document.getElementById('lblGenderNULL').style.display='inline-block'; flag=false;}
    if(!flag)
        document.getElementById('lblNULL').style.display='block';
    return flag;
}

function checkAddProductTypeCHAR()
{
	var flag=true;
	var txtProductName = document.addProductType.ttxtProductName.value;
    var txtCategory = document.addProductType.ttxtCategory.value;

	var strangename =/["'?<>,.!@#$%^&*();\\]/g ;
	
	if(strangename.test(txtProductName))
        {document.getElementById('lblProductNameTypeCHAR').style.display='inline-block'; flag=false;}
	
    if(strangename.test(txtCategory))
        {document.getElementById('lblCategoryCHAR').style.display='inline-block'; flag=false;}

	return flag;
		
}


function checkAddProductType()
{
    var flag=true;

    document.getElementById('lblProductNameTypeNULL').style.display='none';
    document.getElementById('lblGenderNULL').style.display='none';
    document.getElementById('lblCategoryNULL').style.display='none';

    flag=checkAddProductTypeNULL()
    if(!checkAddProductTypeCHAR())
        flag=checkAddProductTypeCHAR();
	return flag;
}

function Reset()
{
    document.addProductType.ttxtProductName.value="";
    document.addProductType.tslcGender.value="";
    document.addProductType.ttxtCategory.value="";

}

function checkEditProductTypeNULL()
{
    var flag=true;
    var txtProductName = document.editProductType.etxtProductName.value;

    document.getElementById('lblProductNameTypeNULL').style.display='none';
	document.getElementById('lblECHAR').style.display='none';

    if(txtProductName.length==0)
        {document.getElementById('lblProductNameTypeNULL').style.display='inline-block'; flag=false;}
    if(!flag)
        document.getElementById('lblNULL').style.display='block';
	return flag;
}

function checkEditProductTypeCHAR()
{
	var flag=true;
    var txtProductName = document.editProductType.etxtProductName.value;
	var strangename =/["'?<>,.!@#$%^&*();\\]/g ;
	
	document.getElementById('lblProductNameTypeNULL').style.display='none';
	document.getElementById('lblECHAR').style.display='none';
	
	if(txtProductName.match(strangename))
        {
			document.getElementById('lblProductNameTypeNULL').style.display='inline-block'; flag=false;}
	if(!flag)
	{document.getElementById('lblECHAR').style.display='block';}
	return flag;
}
function checkEditProductType()
{
	
    flag=true;
    flag=checkEditProductTypeNULL();
	flag=checkEditProductTypeCHAR();
    flag=checkEditProductTypeNULL();
	flag=checkEditProductTypeCHAR();
	return flag;
}

function check_SigninAdmin()
{
    var txtEmail = signinform.email.value;
    var txtPassword = signinform.pass.value;
	var txtRepassword = signinform.repass.value;
	var txtFullname = signinform.fullname.value;
	var txtPhonenumber = signinform.phone.value;
	var txtAddress= signinform.address.value;
	var strangeemail =/[A-Z0-9._%+-]+@[A-Z0-9-]+.+.[A-Z]{2,4}/igm ;
	var strangename =/[~\+\-\_\[\]<>:\;!@#$%^&*()\\]/g ;
	var numname =/[0-9]/g;
	var phonecheck =/^0+[0-9]{8,11}$/;
	var addresscheck =/[\\!#$%^&*()-_=+{}[]|\.?]/g;
    var slcAuth = signinform.slcAuth.value; // Lấy giá trị của quyền được chọn

    document.getElementById('nullEmail').style.display='none';
    document.getElementById('wrongEmail').style.display='none';
    document.getElementById('wrongPassword').style.display='none';
	document.getElementById('nullPassword').style.display='none';
	document.getElementById('wrongRepassword').style.display='none';
	document.getElementById('nullFullname').style.display='none';
	document.getElementById('strangeFullname').style.display='none';
	document.getElementById('wrongPhonenumber').style.display='none';
	document.getElementById('nullPhonenumber').style.display='none';
	document.getElementById('nullAddress').style.display='none';
	document.getElementById('wrongAddress').style.display='none';
    document.getElementById('numIDAdmin').style.display='none';
    document.getElementById('nullAuth').style.display = 'none'; // Reset thông báo chọn quyền

	flag=true;
	var phoneflag = true;
	var emailflag = true;
	var passflag = true;
	var fnameflag = true;
    /*Check NULL*/
    if(txtEmail.length==0)
    {
        document.getElementById('nullEmail').style.display='block';
        flag=false;
		emailflag = false;
    }

    if(txtPassword.length==0)
    {
        document.getElementById('nullPassword').style.display='block';
        flag=false;
		passflag = false;
    }

    if(txtRepassword.length==0)
    {
        document.getElementById('wrongRepassword').style.display='block';
        flag=false;
    }

    if(txtFullname.length==0)
    {
        document.getElementById('nullFullname').style.display='block';
        flag=false;
    }

    if(txtPhonenumber.length==0)
    {
        document.getElementById('nullPhonenumber').style.display='block';
        flag=false;
		phoneflag = false;
    }
	if(txtAddress.length==0)
    {
        document.getElementById('nullAddress').style.display='block';
        flag=false;
    }
	
    /* Check NULL for Auth */
    if (slcAuth == '') {
        document.getElementById('nullAuth').style.display = 'block';
        flag = false;
    }
    /*Check strange character*/
	if(txtEmail.match(strangeemail)==null && emailflag==true)
	{
		 document.getElementById('wrongEmail').style.display='block';
		 flag=false;
	}
	if(txtFullname.match(strangename))
	{
		document.getElementById('strangeFullname').style.display='block';
		flag=false;
		fnameflag = false;
	}
		if(txtFullname.match(numname) && fnameflag==true)
	{
		document.getElementById('numIDAdmin').style.display='block';
		flag=false;
	}
		
	/*Check phone number*/
	if(txtPhonenumber.match(phonecheck)==null && phoneflag==true)
	{
		document.getElementById('wrongPhonenumber').style.display='block';
		flag=false;
    }
    
	/* Check pass length*/
	if(txtPassword.length < 8 && passflag == true)
	{
		document.getElementById('wrongPassword').style.display='block';
		flag=false;
    }
    
	/*Check pass and Retype Pass*/
    if(txtPassword != txtRepassword)
    {
        document.getElementById('wrongRepassword').style.display='block';
        flag=false;
    }

    return flag;
}

/*
    Confirm Delete
*/

function confirmDel()
{
    confirmed = confirm("Bạn có chắc muốn sửa/xóa không???");
    return confirmed;
}
// xỬ LÝ FORMAT SỐ
function formatPrice(input) {
    let value = input.value.replace(/[^\d]/g, '');
    input.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}
