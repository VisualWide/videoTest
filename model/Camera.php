<?php

/**
 * Created by PhpStorm.
 * User: woodenwang
 * Date: 2019/8/29
 * Time: 15:56
 */
class CameraModel extends MysqlDb
{
    public function getAllCameraInfo(){
        $sql = "SELECT * FROM camera;";
        return parent::select($sql);
    }

    /**
     * @param $postArr
     * @return int
     */
    public function insert($postArr)
   {
       $sql = "INSERT into camera(Id,nick_name,Ip,user,pwd,FPS,priority,area,) VALUES ('".$postArr["camera_id"]."','".$postArr["camera_nickName"]."','".$postArr["camera_ip"]."','".$postArr["camera_user"]."','".$postArr["camera_pwd"]."','".$postArr["camera_fps"]."','".$postArr["camera_priority"]."','".$postArr["camera_area"]."');";
       return parent::add($sql); // TODO: Change the autogenerated stub
   }

    public function delete($_id)
    {
        $sql = "DELETE FROM camera WHERE Id=".$_id;
        return parent::delete($sql); // TODO: Change the autogenerated stub
    }

    public function update($postArr)
    {
        $sql = "UPDATE camera SET nick_name='".$postArr["camera_nickName"]."',Ip='".$postArr["camera_ip"]."',user='".$postArr["camera_user"]."',pwd='".$postArr["camera_pwd"]."',FPS='".$postArr["camera_fps"]."',priority='".$postArr["camera_priority"]."',area='".$postArr["camera_area"]."' WHERE id=".$postArr["camera_id"];
        return parent::update($sql); // TODO: Change the autogenerated stub
    }

    public function getRowCount()
    {
        $sql = "SELECT COUNT(*) from camera";
        return parent::getCount($sql); // TODO: Change the autogenerated stub
    }

    public function selectName()
    {
        $sql = "SELECT nick_name from camera ";
        return parent::select($sql); // TODO: Change the autogenerated stub
    }


    public function selectSomeInfo()
    {
        $sql = 'SELECT camera.Id as id, nick_name,algorithm_url,algorithm_name  FROM camera,algorithm WHERE area = algorithm_url';
        return parent::select($sql); // TODO: Change the autogenerated stub
    }

}