<div class="tablediv" data-table="shifttypes">

<table class="table table-sm table-bordered table-hover table-condensed fb_sc_table">
    <thead>
        <tr>
            <th>Shift Type</th>
            <th>Color hex code</th>
            <th></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ( $rows as $val ) :?>
        <tr data-id="<?= $val->shifttype_id ?>">
            <td><?= $val->shifttype_name ?></td>
            <td><?= $val->shifttype_colorcode ?></td>
            <td>
                <div class="btn-group btn-group-toggle">
                    <button class="btn btn-sm btn-info btn-edit-shifttype"><span class="dashicons dashicons-edit"></span></button>
                    <button class="btn btn-sm btn-danger btn-delete-shifttype"><span class="dashicons dashicons-trash"></span></button>
                </div>
            </td>
        </tr>
        <?php endforeach;?>
    </tbody>

</table>

<nav >
  <ul class="pagination">
    <?php
    for ($a=1; $a <= ceil($count/$limit); $a++) :

    ?><li class="page-item <?php echo ($page+1==$a) ? 'active' : '' ?>">
<a class="page-link" href="#" data-page="<?= $a ?>"><?= $a ?></a>
</li><?php
    endfor;
    ?>
  </ul>
</nav>
</div>
