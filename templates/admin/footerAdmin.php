</td>

<td width="300px" class="sidebar">
    <div class="sidebarHeader">Меню</div>
    <ul>
        <li><a href="/">Главная страница</a></li>
        <? if (!empty($user)) :
            if ($user->isAdmin()) :?>
                <li><a href="/articles/add">Добавить статью</a></li>
                <li><a href="/admin/view">Редактировать статьи и комментарии</a></li>
                <li><a href="/admin/users">Редактирование пользователей</a></li>
            <? endif;
        endif; ?>
    </ul>
</td>
</tr>

</table>

</body>
</html>
