<style>
.panel-user-info {
  display: flex;
  align-items: center;
}

.panel-user-avatar {
  flex-shrink: 0;
}

.panel-user-avatar img {
  width: 50px; 
  height: 50px;
  border-radius: 4px;
}

.panel-user-details {
  flex: 1;
}

.panel-user-name {
  margin: 0;
  font-weight: 500;
  color: #ffffff;
  margin-left: 10px;
}

.panel-user-id {
  font-size: 0.8rem;
  color: #ffffff;
}
</style>

<div class="panel-user-info">
  <div class="panel-user-avatar">
    <x-filament-panels::avatar.user :user="auth()->user()" />
  </div>
  <div class="panel-user-details">
    <p class="panel-user-name">{{ Auth::user()->name }}</p>
  </div>
</div>
