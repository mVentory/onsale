<<<<<<< HEAD
Magento Ticketing System
=======

Todo
=======

Frontend
* <del>Check if ticket displays only to the customer that created it (e.g. view/id/1)</del>
* <del>Style "new ticket" button</del>
* Modify the display of ticket / comment timestamp ($ticket->getTimestamp(), $comment->getTimestamp())

Backend
* <del>Display customers name or email according to customer ID</del>
* <del>Onclick action in the grid</del>
  <del>* Status (open/resolved)</del>
  <del>* Implement ticket responding (adding a comment to the ticket)</del>

System/config
* Implement email notifications when a new ticket is open / comment is posted to the ticket admin responded to 

Tables
* Add a column that corresponds to store id where the ticket was created (inchoo_ticketing_ticket.store_id), comments will automatically fall back accoring to ticket ID that is unique in all our stores, and comments are linked to tickets with a FK
=======
lenses
======
>>>>>>> 0c1b900158d0d50452e90d40e3984bdfd15a933a
