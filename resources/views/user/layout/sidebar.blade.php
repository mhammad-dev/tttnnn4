<nav class="sidebar">
  <div class="sidebar-header">
    <a href="#" class="sidebar-brand">
      Care<span>Cover</span>
    </a>
    <div class="sidebar-toggler not-active">
      <span></span>
      <span></span>
      <span></span>
    </div>
  </div>
  <div class="sidebar-body">
    <ul class="nav">
      <li class="nav-item nav-category">Main</li>
      <li class="nav-item {{ active_class(['/']) }}">
        <a href="{{ url('/') }}" class="nav-link">
          <i class="link-icon" data-feather="box"></i>
          <span class="link-title">Dashboard</span>
        </a>
      </li>
      <li class="nav-item nav-category">Referrals</li>
    
      <li class="nav-item {{ active_class(['referral_link']) }}">
        <a href="{{ url('/referral_link') }}" class="nav-link">
          <i class="link-icon" data-feather="message-square"></i>
          <span class="link-title">Referral Link</span>
        </a>
      </li>
      <li class="nav-item {{ active_class(['myreferral']) }}">
        <a href="{{ url('myreferral') }}" class="nav-link">
          <i class="link-icon" data-feather="calendar"></i>
          <span class="link-title">Direct Invitations</span>
        </a>
      </li>

      <li class="nav-item nav-category">Products</li>
      <li class="nav-item {{ active_class(['group-products-list']) }}">
        <a href="{{ url('group-products-list') }}" class="nav-link">
          <i class="link-icon" data-feather="calendar"></i>
          <span class="link-title">Group Products List</span>
        </a>
      </li>
      <li class="nav-item {{ active_class(['products-list']) }}">
        <a href="{{ url('products-list') }}" class="nav-link">
          <i class="link-icon" data-feather="calendar"></i>
          <span class="link-title">Products List</span>
        </a>
      </li>

      <li class="nav-item nav-category">Reward</li>
      <li class="nav-item {{ active_class(['rewards']) }}">
        <a href="{{ url('rewards') }}" class="nav-link">
          <i class="link-icon" data-feather="calendar"></i>
          <span class="link-title">Care Cover Rewards</span>
        </a>
      </li>
      <li class="nav-item nav-category">Transactions</li>
      <li class="nav-item {{ active_class(['transactions']) }}">
        <a href="{{ url('transactions') }}" class="nav-link">
          <i class="link-icon" data-feather="calendar"></i>
          <span class="link-title">My Transactions</span>
        </a>
      </li>

      <li class="nav-item nav-category">Commissions</li>
      <li class="nav-item {{ active_class(['commissions']) }}">
        <a href="{{ url('commissions') }}" class="nav-link">
          <i class="link-icon" data-feather="calendar"></i>
          <span class="link-title">My Commissions</span>
        </a>
      </li>

      <li class="nav-item nav-category">Profit Earned</li>
      <li class="nav-item {{ active_class(['group-profit-earned']) }}">
        <a href="{{ url('group-profit-earned') }}" class="nav-link">
          <i class="link-icon" data-feather="calendar"></i>
          <span class="link-title">Group Profit Earned</span>
        </a>
      </li>
      
    </ul>
  </div>
</nav>
