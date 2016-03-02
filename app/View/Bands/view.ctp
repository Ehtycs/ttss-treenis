<div class="separate-block">
<h2><?php echo h($bandData['Band']['name']); ?></h2>


<?php // display this for admin only too
echo AuthComponent::user('admin') ? $this->Html->link(__('Edit name'), array('controller' => 'bands',
                                                       'action' => 'edit', $bandData['Band']['id'])) : ""; ?>
&nbsp
<?php // Display this only for admins
echo AuthComponent::user('admin') ? $this->Form->postLink(__('Delete band'), 
                                 array('action' => 'remove', $bandData['Band']['id']),
                                 array(), 'This will delete the band '.$bandData['Band']['name'].', all member relations,'.
                                 ' reservation accounts, reservations and login accounts, but members will not be deleted.'.
								 ' Confirm deletion of band?') : ""; ?>
</div>

<div class="separate-block">
<h3>Members</h2>
<?php echo $this->element('MemberList', array('members' => $bandData['Member'], 'membership' => true)); ?>

</table>

<?php // Display member addition only for admins
echo AuthComponent::user('admin') ? $this->Html->link(__('Add a member'), array('controller' => 'BandMemberships',
                                                       'action' => 'add', $bandData['Band']['id'])) : ""; ?>
</div>

<div class="separate-block">

<h3>Reservation accounts</h3>
<?php echo $this->element('list_timeslots_of_band', 
                          array('reservationAccountData' => $reservationAccountData,
                                'actions' => AuthComponent::user('admin')
                          )); ?>

<?php // Display these only for admins too
if(AuthComponent::user('admin')):?>
<?php echo $this->Html->link(__('Add booking account'), array('controller' => 'ReservAccount',
                                                       'action' => 'add', $bandData['Band']['id'])); ?>
&nbsp
<?php echo $this->Html->link(__('Add owned timeslot'), array('controller' => 'ConstReservAccount',
                                                       'action' => 'add', $bandData['Band']['id'])); ?>
<?php endif; ?>                                          
</div>