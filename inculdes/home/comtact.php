


    <section class="abh-sec" id="contact">
      <div class="abh-wrap abh-contact">
        <div>
          <h2 class="abh-h2">Contact</h2>
          <p class="abh-lead">Tell me about your website or web application.</p>
          <?php if ($S['email'] ?? ''): ?><p>Email: <a href="mailto:<?= $v('email') ?>"><?= $v('email') ?></a></p><?php endif; ?>
          <?php if ($S['phone'] ?? ''): ?><p>Phone: <?= $v('phone') ?></p><?php endif; ?>
        </div>
        <form class="abh-form" id="abhForm" data-wait="<?= (int)$wait ?>" method="post" action="contact.php">
          <?php if (isset($_GET['sent'])): ?><p class="abh-ok" role="status">Thanks, your message was sent.</p><?php elseif (isset($_GET['wait'])): ?><p class="abh-bad" role="alert">You already sent a message recently. Please wait for the timer below.</p><?php elseif (isset($_GET['err'])): ?><p class="abh-bad" role="alert"><?= (int)$_GET['err'] === 2 ? 'Your message could not be saved. Please try again later.' : ((int)$_GET['err'] === 3 ? 'Session expired. Reload the page and try again.' : 'Please check the form: all fields except phone are required.') ?></p><?php endif; ?>
          <input type="hidden" name="csrf" value="<?= abh_e(abh_csrf()) ?>">
          <input class="abh-hp" type="text" name="abh_hp_x" tabindex="-1" autocomplete="off" aria-hidden="true">
          <div class="abh-row"><label>Name<input name="name" required minlength="2" maxlength="100" autocomplete="name"></label><label>Email<input type="email" name="email" required maxlength="150" autocomplete="email"></label></div>
          <div class="abh-row"><label>Phone (optional)<input type="tel" name="phone" maxlength="30" autocomplete="tel"></label><label>Subject<input name="subject" required minlength="3" maxlength="150"></label></div>
          <label>Message<textarea name="message" rows="5" required minlength="10" maxlength="3000"></textarea></label>
          <button class="abh-btn abh-btn-pri" id="abhSend" type="submit">Send Message</button>
          <p class="abh-wait" id="abhWait" role="timer" hidden></p>
        </form>
      </div>
    </section>

