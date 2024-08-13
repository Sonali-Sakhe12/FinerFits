<?php
if($_SERVER['REQUEST_METHOD']=='POST')
{
    require_once("include/initialize.php");
    $db = New Database(); 

    $content = json_decode(trim(file_get_contents("php://input")));
    $id = $content->id;
    $user = $content->user;
    $mode = $content->mode;

    if($mode == 'add')
    {
    $status = 1;
    $proqty = 1;

    $sql = $db->conn->prepare("INSERT INTO tblcart(USER, PROID, CARTQTY, status) select ?,?,?,? where not exists (select * from tblcart where USER=? and PROID=?) ");
    $sql->bind_param("ssssss",$user,$id,$proqty,$status,$user,$id);
    $sql->execute();
    if($sql->affected_rows > 0)
    {
        $response = array('status'=>"1","msg"=>"success");
    }else{
        $response = array('status'=>"0","msg"=>"Already Exist");  
    }
    }else if($mode == 'remove')
    {
        $sql = $db->conn->prepare('delete from tblcart where id=?');
        $sql->bind_param("s",$id);
        $sql->execute();
        if($sql->affected_rows > 0)
        {
            $response = array('status'=>"1","msg"=>"success");
        }else{
            $response = array('status'=>"0","msg"=>"Something went wrong");  
        }
    }elseif($mode == 'plus')
    {
        $sql = $db->conn->prepare('update tblcart set CARTQTY= CARTQTY+1 where id=?');
        $sql->bind_param("s",$id);
        $sql->execute();
        if($sql->affected_rows > 0)
        {
            $response = array('status'=>"1","msg"=>"success");
        }else{
            $response = array('status'=>"0","msg"=>"Something went wrong");  
        }
    }elseif($mode == 'minus')
    {
        $sql = $db->conn->prepare('update tblcart set CARTQTY= CARTQTY-1 where id=? and CARTQTY>1');
        $sql->bind_param("s",$id);
        $sql->execute();
        if($sql->affected_rows > 0)
        {
            $response = array('status'=>"1","msg"=>"success");
        }else{
            $response = array('status'=>"0","msg"=>"Something went wrong");  
        }
    }
}else{
    $response = array('status'=>"0","msg"=>"something went wrong");
}

echo json_encode($response);


?>