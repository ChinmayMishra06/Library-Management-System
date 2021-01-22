<div class="container-fluid">
	<div class="row">
		<!-- This will create sidebar. -->
		<div class="col-sm-2 d-print-none" id="sidebar">
			<div class="row min-vh-100">
				<div class="col">
					<div id="accordion">
						<!-- This will display issue book menu bar and it's item. -->
						<div id="issue-book-menu">
							<div class="card-header card-padding">
								<i class="text-white fa fa-shopping-cart"></i>
								<a href="" class="collapsed text-white" data-toggle="collapse" data-target="#issue-book-menu-item">Issue Book</a>
							</div>
							<div class="collapse" id="issue-book-menu-item" data-parent="#accordion">
								<div class="card-body">
									<a href="<?= base_url('index.php/book/book_issue'); ?>" class="nav-link text-white">Issue</a>
									<a href="<?= base_url('index.php/book/search_issued_book'); ?>" class="nav-link text-white">Return</a>
									<a href="<?= base_url('index.php/book/all_issued_books'); ?>" class="nav-link text-white">All</a>
								</div>
							</div>
						</div>
						
						<!-- This will display book menu bar and it's item. -->
						<div id="book-menu">
							<div class="card-header card-padding">
								<i class="text-white fa fa-book"></i>
								<a href="" class="collapsed text-white" data-toggle="collapse" data-target="#book-menu-item">Book</a>
							</div>
							<div class="collapse" id="book-menu-item" data-parent="#accordion">
								<div class="card-body">
									<a href="<?= base_url('index.php/book/'); ?>" class="nav-link text-white">New</a>
									<?php if($this->session->userdata('admin')): ?>
										<a href="<?= base_url('index.php/book/search_book_update'); ?>" class="nav-link text-white">Update</a>
									<?php endif; ?>
									<a href="<?= base_url('index.php/book/all_books'); ?>" class="nav-link text-white">All</a>
								</div>
							</div>
						</div>

						<!-- This will display member menu bar and it's item. -->
						<div id="member-menu">
							<div class="card-header card-padding">
								<i class="text-white fa fa-user"></i>
								<a href="" class="collapsed text-white" data-toggle="collapse" data-target="#member-menu-item">Member</a>
								</div>
								<div class="collapse" id="member-menu-item" data-parent="#accordion">
								<div class="card-body">
									<a href="<?= base_url('index.php/member/'); ?>" class="nav-link text-white">New</a>
									<a href="<?= base_url('index.php/member/search_member_update'); ?>" class="nav-link text-white">Update</a>
									<a href="<?= base_url('index.php/member/search_member_details'); ?>" class="nav-link text-white">Details</a>
									<a href="<?= base_url('index.php/member/all_members'); ?>" class="nav-link text-white">All</a>
								</div>
							</div>
						</div>

						<!-- This will display librarian menu bar and it's item. -->
						<?php if($this->session->userdata('admin')): ?>									
							<div id="librarian-menu">
								<div class="card-header card-padding">
									<i class="text-white fa fa-address-card"></i>
									<a href="" class="collapsed text-white" data-toggle="collapse" data-target="#librarian-menu-item">Librarian</a>
									</div>
									<div class="collapse" id="librarian-menu-item" data-parent="#accordion">
									<div class="card-body">
										<a href="<?= base_url('index.php/librarian/'); ?>" class="nav-link text-white">New</a>
										<a href="<?= base_url('index.php/librarian/search_librarian_update'); ?>" class="nav-link text-white">Update</a>
										<a href="<?= base_url('index.php/librarian/search_librarian_details'); ?>" class="nav-link text-white">Details</a>
										<a href="<?= base_url('index.php/librarian/all_librarian'); ?>" class="nav-link text-white">All</a>
									</div>
								</div>
							</div>
						<?php endif; ?>

						<!-- This will display subscriber menu bar and it's item. -->
						<div id="subscriber-menu">
							<div class="card-header card-padding">
								<i class="text-white fa fa-rupee-sign"></i>
								<a href="" class="collapsed text-white" data-toggle="collapse" data-target="#subscriber-menu-item">Subscriber</a>
								</div>
								<div class="collapse" id="subscriber-menu-item" data-parent="#accordion">
								<div class="card-body">
									<a href="<?= base_url('index.php/subscriber/'); ?>" class="nav-link text-white">New</a>
									<a href="<?= base_url('index.php/subscriber/search_subscriber_update'); ?>" class="nav-link text-white">Update</a>
									<a href="<?= base_url('index.php/subscriber/search_subscriber_details'); ?>" class="nav-link text-white">Details</a>
									<a href="<?= base_url('index.php/subscriber/all_subscribers'); ?>" class="nav-link text-white">All</a>
								</div>
							</div>
						</div>

						<!-- This will display plan menu bar and it's item. -->
						<div id="plan-menu">
							<div class="card-header card-padding">
								<i class="text-white fa fa-chart-bar"></i>
								<a href="" class="collapsed text-white" data-toggle="collapse" data-target="#plan-menu-item">Plans</a>
								</div>
								<div class="collapse" id="plan-menu-item" data-parent="#accordion">
								<div class="card-body">
									<?php if($this->session->userdata('admin')): ?>
										<a href="<?= base_url('index.php/plan/'); ?>" class="nav-link text-white">New</a>
										<a href="<?= base_url('index.php/plan/search_plan_update'); ?>" class="nav-link text-white">Update</a>
									<?php endif; ?>
									<a href="<?= base_url('index.php/plan/all_plans'); ?>" class="nav-link text-white">All</a>
								</div>
							</div>
						</div>

						<!-- This will display personalize menu bar and it's item. -->
						<div id="personalize-menu">
							<div class="card-header card-padding">
								<i class="text-white fa fa-smile"></i>
								<a href="" class="collapsed text-white" data-toggle="collapse" data-target="#personalize-menu-item">Personalize</a>
								</div>
								<div class="collapse" id="personalize-menu-item" data-parent="#accordion">
								<div class="card-body">									
									<?php if($this->session->userdata('admin')): ?>
										<!--<a href="< ?= base_url('index.php/personalize/about_me'); ?>" class="text-white nav-link">About Me</a>-->
										<!--<a href="< ?= base_url('index.php/personalize/contact_me'); ?>" class="text-white nav-link">Contact Me</a>-->
										<!--<a href="< ?= base_url('index.php/personalize/about_project'); ?>" class="text-white nav-link">About Project</a>-->
										<!--<a href="< ?= base_url('index.php/personalize/resume'); ?>" class="text-white nav-link">Resume</a>-->
									<?php endif; ?>
									<a href="<?= base_url('index.php/personalize/'); ?>" class="text-white nav-link">Profile</a>
									<a href="<?= base_url('index.php/librarian/logout'); ?>" class="text-white nav-link">Logout</a>
								</div>
							</div>
						</div>
					</div>
				</div>	
			</div>
		</div>
		<div class="col-sm-10">