 <?php
 /**
   * Build a table of bands out of array $bands
   * $bands should be array( array('key1' => 'val1'), array(...) ... );
   */
 ?>
<table>
    <tr>
        <th>Id</th>
        <th>Name</th>
    </tr>
    
    <?php foreach($bands as $m): ?>
    <tr>
         <td><?php echo $m['id']; ?></td>
         <td><?php echo $this->Html->link($m['name'], 
                     array('controller' => 'bands', 
                           'action' => 'view', 
                           $m['id'])); ?></td>
    </tr>
    <?php endforeach; ?>
    <?php unset($m); ?>
    
</table>