<div class="ws-container">
    <div class="ws-g ws-c">
        <div class="ws-u-1 ws-u-lg-1-2">
            <div class="ws-g">
                <div class="ws-u-1 ws-u-sm-1-2">
                    <span class="h">Kontakt</span>
                    <p class="address" style="width: 50%"><span>{{ $config->address }}</span></p>
                    <p class="hotline"><a
                            href="tel:{{ preg_replace('/\D/', '', $config->hotline) }}">{{ $config->hotline }}</a>
                    </p>
                    <p class="phone_number"><a
                            href="tel:{{ preg_replace('/\D/', '', $config->phone_number) }}">{{ $config->phone_number }}</a>
                    </p>
                    <p class="email"><a href="mailto:{{ $config->email }}">{{ $config->email }}</a></p>

                </div>
                <div class="ws-u-1 ws-u-sm-1-2">
                    <span class="h">Über uns</span>
                    <a class="a" href="/service/impressum">Impressum</a>
                    <a class="a" href="/service/agb">AGB</a>
                    <a class="a" href="/service/widerruf">Widerruf</a>
                    <a class="a" href="/service/datenschutz">Datenschutz</a>
                    <a class="a" href="/service/kontakt">Kontakt</a>
                </div>
            </div>
        </div>

        <div class="ws-u-1 ws-u-lg-1-2">
            <div class="ws-g">
                <div class="ws-u-1 ws-u-sm-1-2">
                    <div class="ws-g">
                        <div class="ws-u-1">
                            <span class="h">Versandmitarbeiter</span>
                            <span class="a">DHL</span>
                            <span class="a">UPS</span>
                            <a class="a" href="/service/versandkosten">Versandkosten</a>
                        </div>
                    </div>
                </div>
                <div class="ws-u-1 ws-u-sm-1-2">
                    <div class="ws-g">
                        <div class="ws-u-1">
                            <span class="h">Jugendschutz</span>
                            <div class="ws-g adult-only">
                                <div>
                                    <span class="ws-u-5-24">
                                        <i class="fa fa-ban"></i>
                                    </span>
                                    <span class="ws-u-19-24">
                                        {{ $config->restriction_message }}
                                    </span>
                                </div>
                            </div>
                            <span class="a">
                                {{ $config->adult_only_policy }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="ws-u-1 copyright">
            {{ $config->copyright }}
        </div>
    </div>
</div>
