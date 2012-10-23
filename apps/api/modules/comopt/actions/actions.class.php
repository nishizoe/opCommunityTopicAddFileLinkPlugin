<?php
class comoptActions extends opJsonApiActions
{
  public function executeList(sfWebRequest $request)
  {
    // 2系のDB検索のため、直接SqLをたたきます
    $communityId = $request['id'];
    $type = $request['type'];
    // todo:n エラー処理
    $sql = '';
    $sql .= 'select c_file_id, filename, original_filename from c_file';
    $sql .= ' where filename like "';
    if ('topic' == $type)
    {
      $sql .= 't_';
    }
    elseif ('comment' == $type) {
      $sql .= 'tc_';
    }
    $sql .= $communityId.'_4_%';
    $sql .= '"';

    $conn = Doctrine::getTable('Member')->getConnection();
    $files = $conn->fetchAll($sql);

    return $this->renderJSON(array('status' => 'success', 'data' => $files));
  }
}
