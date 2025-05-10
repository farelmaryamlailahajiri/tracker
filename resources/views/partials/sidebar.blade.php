<aside class="w-56 h-screen bg-white shadow-lg fixed top-0 left-0 z-40">
  <div class="flex items-center justify-center h-20 border-b">
    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10 object-contain">
  </div>
  <nav class="p-4">
    <ul class="space-y-2">
      <li>
        <a href="/dashboard" class="flex items-center p-2 text-blue-700 bg-blue-100 rounded">
          <i class="ri-home-4-line text-lg mr-2"></i>
          <span>Home</span>
        </a>
      </li>
      <li>
        <a href="#" class="flex items-center p-2 text-gray-700 hover:text-blue-700 hover:bg-blue-50 rounded">
          <i class="ri-user-3-line text-lg mr-2"></i>
          <span>Data Lulusan</span>
        </a>
      </li>
      <li>
        <a href="#" class="flex items-center p-2 text-gray-700 hover:text-blue-700 hover:bg-blue-50 rounded">
          <i class="ri-briefcase-line text-lg mr-2"></i>
          <span>Data Profesi</span>
        </a>
      </li>
      <li>
        <a href="#" class="flex items-center p-2 text-gray-700 hover:text-blue-700 hover:bg-blue-50 rounded">
          <i class="ri-apps-line text-lg mr-2"></i>
          <span>Applications</span>
        </a>
      </li>
      <li>
        <a href="#" class="flex items-center p-2 text-gray-700 hover:text-blue-700 hover:bg-blue-50 rounded">
          <i class="ri-bar-chart-2-line text-lg mr-2"></i>
          <span>Laporan</span>
        </a>
      </li>
      <li>
        <a href="#" class="flex items-center p-2 text-gray-700 hover:text-blue-700 hover:bg-blue-50 rounded">
          <i class="ri-mail-line text-lg mr-2"></i>
          <span>Email Instansi</span>
        </a>
      </li>
    </ul>
  </nav>
  <div class="absolute bottom-4 w-full px-4">
    <a href="/logout" class="flex items-center p-2 text-red-600 hover:bg-red-50 rounded">
      <i class="ri-logout-circle-line text-lg mr-2"></i>
      <span>Log out</span>
    </a>
  </div>
</aside>