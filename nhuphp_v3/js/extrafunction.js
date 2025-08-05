// chuyển đổi số thành chuỗi định dạng giá tiền
function PriceDot(text)
{
    var a = text +'';
    var temp = "";	
    var start = a.length-3;
    var end = a.length;
    while(a.length>3)
    {
        temp = '.'+a.slice(start,end) + temp;
        a = a.slice(0,start);
        start = start - 3;
        end = end - 3;
    }
    temp = a + temp+ '<sup>₫</sup>';
    return temp;
}

// kiểm tra sl sản phẩm trong kho và số lượng người dùng nhập
function checkQuant()
{
	var quant = parseInt(document.productdetails.checkQuantity.value);
    var inpquant = parseInt(document.productdetails.txtQuantity.value);
	if((quant==0))
	{
		alert("Đã hết hàng");
		return false;
	}
	if((inpquant>quant))
	{
		alert("Hàng trong kho không đủ cung cấp");
		return false;
	}
		return true;
}

// kiểm tra coi nhập có phải là số hay không [có thể dùng space and delete]
function Keypress(e)
{
    var keypressed = null;
    if (window.event)
    {
        keypressed = window.event.keyCode;
    }
    else 
    {
        keypressed = e.which; 
    }
    if (keypressed < 48 || keypressed > 57)
    { 
        if (keypressed == 8 || keypressed == 127)
        {
            return;	
        }
    return false;
    }
}

// thêm dấu chấm phân cách hàng nghìn vào giá trị
function addDot(a)
{
	a.value = a.value.replace(/[.]+/g,"")
  	a.value = a.value.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
}

// kiểm tra đăng nhập 
function check_Login()
{	
	var txtEmail = loginform.email.value;
	var txtPassword = loginform.pass.value;
	document.getElementById('nullID').style.display='none';
    document.getElementById('wrongID').style.display='none';
    document.getElementById('wrongIDpass').style.display='none';
	document.getElementById('nullIDpass').style.display='none';

	var flag=true;
	if(txtEmail.length==0)
    {
        document.getElementById('nullID').style.display='block';
        flag=false;
    }

    if(txtPassword.length==0)
    {
        document.getElementById('nullIDpass').style.display='block';
        flag=false;
    }
	
    return flag;
} 

/*
    For register box
*/
// kiểm tra đăng ký
function check_Signin()
{
    var txtEmail = signinform.email.value;
    var txtPassword = signinform.pass.value;
	var txtRepassword = signinform.repass.value;
	var txtFullname = signinform.fullname.value;
	var txtPhonenumber = signinform.phone.value;
	var txtAddress= signinform.address.value;
	var strangeemail =/[A-Z0-9._%+-]+@[A-Z0-9-]+.+.[A-Z]{2,4}/igm ;
	var strangename =/[~`\+\-\_\[\]<>:\;!@#$%^&*()\\]/g ;
	var numname =/[0-9]/g;
	var phonecheck =/^0+[0-9]{8,11}$/;
	var addresscheck =/[!#$%^&*()-_=+{}[]|\.?]/g;
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
    document.getElementById('numID').style.display='none';
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
	
    /*Check strange character*/
	if(txtEmail.match(strangeemail)==null && emailflag==true)
	{
		 document.getElementById('wrongEmail').style.display='block';
		 flag=false;
	}
	if(txtEmail.match(strangeemail)==null && emailflag==true)
	{
		 document.getElementById('wrongEmail').style.display='block';
		 flag=false;
	}
	
	if(txtFullname.match(strangename))
	{
		document.getElementById('strangeFullname').style.display='block';
		flag=false;
		fnameflag=false;
	}
	if(txtFullname.match(numname) && fnameflag==true)
	{
		document.getElementById('numID').style.display='block';
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
    //For register box 
*/

/*
    For advanced search form
*/

// kiểm tra trong form tìm kiếm
function checkAdvancedSearch() 
{
    txtFrom = document.formAdvanceSearch.txtFrom.value;
    txtTo= document.formAdvanceSearch.txtTo.value;
    flag = true;
    if(txtFrom!=""||txtTo!="")
    {
        txtFrom = txtFrom.replace(/\./g,"");
        txtTo = txtTo.replace(/\./g,"");
        message="";
        if(!/^[\d]+$/.test(txtFrom)&&txtFrom!="")
        {
            message+="Từ";
            flag = false;
        }

        if(!/^[\d]+$/.test(txtTo)&&txtTo!="")
        {
            message+=", Đến";
            flag = false;
        }

        message = message.replace(/^, /,"");
        if(message!="")
        document.getElementById("priceError").innerHTML = message+" phải là số";
    }
    return flag;
}

/*
    For CheckOut
*/
// ử lý sự kiện khi người dùng chọn phương thức vận chuyển trong trang thanh toán.
function switchShipping()
{
    radioShipping = document.getElementsByName('shipping');
    var discountPercentage = parseInt(document.getElementById('discountAmount').innerHTML); // Giảm giá (phần trăm)

    for(i=0;i<radioShipping.length;i++)
    if(radioShipping[i].checked==true)
        if(radioShipping[i].value==0)
        {
            document.getElementById('lblShip').innerHTML=PriceDot(50000);
            document.getElementById('lblTotal').innerHTML=PriceDot(50000+((parseInt(document.getElementById('subTotal').value))-(parseInt(document.getElementById('subTotal').value)*discountPercentage/100)));
        }
        else
        {
            document.getElementById('lblTotal').innerHTML=PriceDot((parseInt(document.getElementById('subTotal').value))-(parseInt(document.getElementById('subTotal').value)*discountPercentage/100));
            document.getElementById('lblShip').innerHTML='0';
        }
// 👉 Gọi lại QR nếu người dùng đang chọn thanh toán bằng QR
    if (document.getElementById('qr').checked) {
        updateQR();
    }
    
}
window.onload=function onloadSwitchShipping()
{
    switchShipping()
}

// Xử lý thanh toán QR

function getTotalFromPage() {
    const lblTotal = document.getElementById('lblTotal');
    if (!lblTotal) return 0;

    // Lấy số từ dạng chuỗi 1.000.000₫ hoặc 1,000,000đ
    const rawText = lblTotal.textContent || "0";
    const number = parseInt(rawText.replace(/[^\d]/g, ""));
    return isNaN(number) ? 0 : number;
}

document.addEventListener('DOMContentLoaded', function () {
    const qrRadio = document.getElementById('qr');
    const cashRadio = document.getElementById('cash');
    const qrSection = document.getElementById('qr-section');
    const qrImage = document.getElementById('qrImage');
    const qrAmountSpan = document.getElementById('qrAmount');

    const totalInput = document.getElementById('subTotal');
    const discountInput = document.getElementById('Discount');

    function updateQR() {
    const amount = getTotalFromPage(); // 👈 lấy từ lblTotal
        qrAmountSpan.textContent = amount.toLocaleString();

        const bank = "VIETCOMBANK"; // mã ngân hàng
        const account = "0421000415149"; // số tài khoản
        const name = "LE NGOC HUAN"; // tên chủ tài khoản viết HOA không dấu
        const info = "THANHTOANHOANGPHAT";

        const qrUrl = `https://img.vietqr.io/image/${bank}-${account}-${encodeURIComponent(name)}.png?amount=${amount}&addInfo=${info}`;
        qrImage.src = qrUrl;
    }

    function toggleQRSection() {
        if (qrRadio.checked) {
            qrSection.style.display = 'block';
            updateQR();
        } else {
            qrSection.style.display = 'none';
        }
    }

    qrRadio.addEventListener('change', toggleQRSection);
    cashRadio.addEventListener('change', toggleQRSection);
});

function updateQR() {
    const amount = parseInt(document.getElementById('lblTotal').textContent.replace(/[^\d]/g, '')) || 0;
    const bank = "VIETCOMBANK";
    const account = "0421000415149";
    const name = "LE NGOC HUAN";
    const info = "THANHTOANHOANGPHAT";
    const qrUrl = `https://img.vietqr.io/image/${bank}-${account}-${encodeURIComponent(name)}.png?amount=${amount}&addInfo=${info}`;
    document.getElementById('qrImage').src = qrUrl;
}
