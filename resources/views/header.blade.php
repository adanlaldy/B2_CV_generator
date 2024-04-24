@if(auth()->check())
    <!-- connected user -->
    <header>
        <nav>
            <ul>
                <li><a href="/my-account">MY ACCOUNT</a></li>
                <li><a href="logout">LOG OUT</a></li>
            </ul>
        </nav>
    </header>
@else
    <!-- ddisconnected user -->
    <header>
        <nav>
            <ul>
                <li><a href="/">CV GENERATOR</a></li>
                <li><a href="/login">LOG IN</a></li>
                <li><a href="/registration">REGISTER</a></li>
            </ul>
        </nav>
    </header>
@endif
