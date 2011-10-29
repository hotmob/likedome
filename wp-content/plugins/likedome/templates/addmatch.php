<?php global $tpl; $matchtypelist = $tpl -> getVar('typelist'); ?>
<form method="post">
    <table border="1" class="widefat" style="line-height:30px;">
        <tr>
            <th width="30%">比赛名称</th>
            <th width="20%">比赛分类</th>
            <th width="20%">队伍上限</th>
            <th width="20%">队员上限</th>
        </tr>
        </thead>
        <tbody id="manage_polls">
            <tr id="poll-4" class="highlight">
                <td><strong> <label>
                    <input type="text" name="name" id="name" size=50 />
                </label> </strong></td>
                <td>
                    <label>
                        <select name="type" id="type">
                            <?php
                                foreach ($matchtypelist as $matchtype) {
                                    echo '<option value="'.$matchtype->id.'">' . $matchtype -> type . '</option>';
                                }
                            ?>
                        </select>
                    </label>
                </td>
                <td><strong>
                <input type="text" name="grouplimit" id="grouplimit" />
                </strong></td>
                <td><strong>
                <input type="text" name="groupmemberlimit" id="groupmemberlimit" />
                </strong></td>
            </tr>
            <tr>
                <td colspan="5" align='center'>
                <input name="category" type="hidden" value="add" h/>
                <input type="submit" name="button" id="button" value="添加比赛" />
                </td>
            </tr>
    </table>
</form>