param([switch]$DryRun)
Set-StrictMode -Version Latest
$ErrorActionPreference = "Stop"

Add-Type -AssemblyName System.Net.Http
Add-Type -AssemblyName System.Web

$base = "https://orbitinternetkenya.co.ke"
$email = "admin@demo.com"
$password = "12345678"

$internalLinks = @(
  "https://orbitinternetkenya.co.ke/starlink-installation-kenya",
  "https://orbitinternetkenya.co.ke/starlink-kenya-price",
  "https://orbitinternetkenya.co.ke/starlink-kenya-packages",
  "https://orbitinternetkenya.co.ke/starlink-internet-kenya",
  "https://orbitinternetkenya.co.ke/starlink-kenya",
  "https://orbitinternetkenya.co.ke/amazon-leo-internet-kenya",
  "https://orbitinternetkenya.co.ke/amazon-kuiper-kenya-6-powerful-signals",
  "https://orbitinternetkenya.co.ke/starlink-mombasa-7-powerful-setup-tips"
)

$externalLinks = @(
  "https://starliteinternetkenya.co.ke/",
  "https://starlinkkenyainstallers.co.ke/",
  "https://amazoninternetkenya.co.ke/",
  "https://spacelinkkenya.co.ke/",
  "https://orbitlinksolutions.co.ke/"
)

$imagePool = @(
  "https://orbitinternetkenya.co.ke/images?path=uploads%2Fimages%2Fstarlink-installation-nairobi-7-proven-tips-1783326509.jpg",
  "https://orbitinternetkenya.co.ke/images?path=uploads%2Fimages%2Fstarlink-mini-kenya-7-powerful-wins-1783325073.jpg",
  "https://orbitinternetkenya.co.ke/images?path=uploads%2Fimages%2Fstarlink-mini-price-kenya-8-smart-facts-1783325076.jpg",
  "https://orbitinternetkenya.co.ke/images?path=uploads%2Fimages%2Fhow-it-works-6-clear-starlink-steps-1783325069.jpg",
  "https://orbitinternetkenya.co.ke/images?path=uploads%2Fimages%2Fabout-us-7-trusted-orbit-facts-1783325067.jpg",
  "https://orbitinternetkenya.co.ke/images?path=uploads%2Fimages%2Fstarlink-installers-kenya-9-trusted-checks-1783326512.jpg",
  "https://spacelinkkenya.co.ke/storage/uploads/images/starlink%20Accesories-1752219513.jpg",
  "https://spacelinkkenya.co.ke/storage/uploads/images/Starlink-Mini-1752131743.webp",
  "https://spacelinkkenya.co.ke/storage/uploads/images/Starlink%20Price%20Kenya-1752131573.png",
  "https://spacelinkkenya.co.ke/storage/uploads/images/strlink%20kenya-1752131423.jpg",
  "https://spacelinkkenya.co.ke/storage/uploads/images/starlink-1752131960.png",
  "https://spacelinkkenya.co.ke/storage/uploads/images/ISP%20Billing%20Software-1752131843.jpg",
  "https://orbitinternetkenya.co.ke/images?path=uploads%2Fimages%2Fstarlink-installation-nairobi-7-proven-tips-1783326509.jpg",
  "https://orbitinternetkenya.co.ke/images?path=uploads%2Fimages%2Fstarlink-mini-kenya-7-powerful-wins-1783325073.jpg",
  "https://orbitinternetkenya.co.ke/images?path=uploads%2Fimages%2Fstarlink-mini-price-kenya-8-smart-facts-1783325076.jpg",
  "https://orbitinternetkenya.co.ke/images?path=uploads%2Fimages%2Fhow-it-works-6-clear-starlink-steps-1783325069.jpg",
  "https://orbitinternetkenya.co.ke/images?path=uploads%2Fimages%2Fabout-us-7-trusted-orbit-facts-1783325067.jpg",
  "https://orbitinternetkenya.co.ke/images?path=uploads%2Fimages%2Fstarlink-installers-kenya-9-trusted-checks-1783326512.jpg"
)

$posts = @(
  @{
    Keyword = "Starlink Customer Service Kenya"
    Title = "Starlink Customer Service Kenya: 7 Trusted Answers"
    H2 = "Starlink Customer Service Kenya help guide"
    Meta = "Starlink Customer Service Kenya guide for account help, installation support, activation issues, payments, troubleshooting, and care."
    Angle = "getting reliable help for account access, setup questions, payment concerns, router issues, and follow-up support"
    Scenario = "homes, lodges, shops, offices, schools, clinics, farms, remote teams, and buyers comparing support options"
    Benefit = "a clear support path when the connection matters"
    Hero = $imagePool[0]
    Images = @($imagePool[0],$imagePool[1],$imagePool[2],$imagePool[3],$imagePool[4],$imagePool[5])
  },
  @{
    Keyword = "Starlink Contact Kenya"
    Title = "Starlink Contact Kenya: 7 Smart Ways"
    H2 = "Starlink Contact Kenya support routes"
    Meta = "Starlink Contact Kenya guide for reaching help, preparing support details, installation questions, account issues, and service guidance."
    Angle = "knowing who to contact, what details to prepare, and how to separate sales questions from support issues"
    Scenario = "new buyers, active users, property managers, SMEs, rural homes, hotels, and teams needing fast guidance"
    Benefit = "faster answers with fewer repeated explanations"
    Hero = $imagePool[6]
    Images = @($imagePool[6],$imagePool[7],$imagePool[8],$imagePool[9],$imagePool[10],$imagePool[11])
  },
  @{
    Keyword = "Starlink Login Kenya"
    Title = "Starlink Login Kenya: 7 Secure Steps"
    H2 = "Starlink Login Kenya account access guide"
    Meta = "Starlink Login Kenya guide for secure account access, app checks, payment review, service plan details, and troubleshooting support."
    Angle = "signing in safely, checking account details, reviewing service status, and avoiding login mistakes"
    Scenario = "customers managing subscriptions, support tickets, payments, app settings, and Starlink service details"
    Benefit = "safer account access and clearer control of the service"
    Hero = $imagePool[12]
    Images = @($imagePool[12],$imagePool[13],$imagePool[14],$imagePool[15],$imagePool[16],$imagePool[17])
  },
  @{
    Keyword = "Starlink Kenya Login"
    Title = "Starlink Kenya Login: 7 Powerful Fixes"
    H2 = "Starlink Kenya Login troubleshooting guide"
    Meta = "Starlink Kenya Login guide for account access, app errors, payment checks, service status, password issues, and support steps."
    Angle = "fixing login errors, account confusion, app access, payment checks, and service management problems"
    Scenario = "users who need to manage Starlink but are blocked by access, password, device, or account issues"
    Benefit = "clear troubleshooting before access problems interrupt service"
    Hero = $imagePool[2]
    Images = @($imagePool[2],$imagePool[4],$imagePool[6],$imagePool[8],$imagePool[10],$imagePool[12])
  },
  @{
    Keyword = "Starlink Account Kenya"
    Title = "Starlink Account Kenya: 7 Clear Wins"
    H2 = "Starlink Account Kenya management guide"
    Meta = "Starlink Account Kenya guide for setup, login, payments, service plans, activation records, support access, and account care."
    Angle = "managing service details, payments, plan information, login records, support history, and ownership notes"
    Scenario = "families, business owners, hotels, schools, clinics, landlords, and remote teams managing Starlink service"
    Benefit = "better account control and fewer support delays"
    Hero = $imagePool[5]
    Images = @($imagePool[5],$imagePool[7],$imagePool[9],$imagePool[11],$imagePool[13],$imagePool[15])
  }
)

function Get-Token([string]$html) {
  $match = [regex]::Match($html, 'name="_token"\s+value="([^"]+)"')
  if (-not $match.Success) { throw "CSRF token not found" }
  return $match.Groups[1].Value
}

function Strip-Html([string]$html) {
  $decoded = [System.Web.HttpUtility]::HtmlDecode(($html -replace '<[^>]+>', ' '))
  return ($decoded -replace '\s+', ' ').Trim()
}

function Count-Words([string]$html) {
  $plain = Strip-Html $html
  if ([string]::IsNullOrWhiteSpace($plain)) { return 0 }
  return ([regex]::Matches($plain, '\b[\w-]+\b')).Count
}

function Count-Phrase([string]$text, [string]$phrase) {
  return ([regex]::Matches($text, [regex]::Escape($phrase), [System.Text.RegularExpressions.RegexOptions]::IgnoreCase)).Count
}

function Find-ExistingPost([string]$pagesHtml, [string]$title) {
  $idx = $pagesHtml.IndexOf($title)
  if ($idx -lt 0) { return $null }
  $start = [Math]::Max(0, $idx - 1200)
  $len = [Math]::Min(2600, $pagesHtml.Length - $start)
  $chunk = $pagesHtml.Substring($start, $len)
  $idMatch = [regex]::Match($chunk, 'name="ids\[\]"\s+value="(\d+)"')
  $urlMatch = [regex]::Match($chunk, '<a href="([^"]+)" target="_blank" class="btn btn-outline-info btn-sm">')
  if (-not $idMatch.Success) { return $null }
  return [pscustomobject]@{
    Id = $idMatch.Groups[1].Value
    Url = if ($urlMatch.Success) { $urlMatch.Groups[1].Value } else { $null }
  }
}

function Find-ExistingPost([string]$pagesHtml, [string]$title) {
  $idx = $pagesHtml.IndexOf($title)
  if ($idx -lt 0) { return $null }
  $start = [Math]::Max(0, $idx - 1200)
  $len = [Math]::Min(2600, $pagesHtml.Length - $start)
  $chunk = $pagesHtml.Substring($start, $len)
  $idMatch = [regex]::Match($chunk, 'name="ids\[\]"\s+value="(\d+)"')
  $urlMatch = [regex]::Match($chunk, '<a href="([^"]+)" target="_blank" class="btn btn-outline-info btn-sm">')
  if (-not $idMatch.Success) { return $null }
  return [pscustomobject]@{
    Id = $idMatch.Groups[1].Value
    Url = if ($urlMatch.Success) { $urlMatch.Groups[1].Value } else { $null }
  }
}

function A([string]$url, [string]$text) {
  return "<a href=""$url"">$text</a>"
}

function ExternalA([string]$url, [string]$text) {
  return "<a href=""$url"" rel=""nofollow noopener"" target=""_blank"">$text</a>"
}

function Para([string]$text) {
  return "<p>$text</p>"
}

function Figure([string]$src, [string]$alt, [string]$caption) {
  return "<figure><img src=""$src"" width=""600"" height=""400"" alt=""$alt""><figcaption>$caption</figcaption></figure>"
}

function Build-Article([hashtable]$post) {
  $kw = $post.Keyword
  $links = @{
    install = A $internalLinks[0] "Starlink installation Kenya"
    price = A $internalLinks[1] "Starlink Kenya price"
    packages = A $internalLinks[2] "Starlink Kenya packages"
    internet = A $internalLinks[3] "Starlink internet Kenya"
    kenya = A $internalLinks[4] "Starlink Kenya"
    leo = A $internalLinks[5] "Amazon Leo internet Kenya"
    kuiper = A $internalLinks[6] "Amazon Kuiper Kenya signals"
    mombasa = A $internalLinks[7] "Starlink Mombasa setup tips"
    starlite = ExternalA $externalLinks[0] "Starlite Internet Kenya"
    installers = ExternalA $externalLinks[1] "Starlink Kenya Installers"
    amazon = ExternalA $externalLinks[2] "Amazon Internet Kenya"
    space = ExternalA $externalLinks[3] "SpaceLink Kenya"
    orbit = ExternalA $externalLinks[4] "Orbit Link Solutions"
  }

  $css = '<style>.article-wrap{font-family:Arial,Helvetica,sans-serif;color:#172033;line-height:1.72;font-size:18px}.article-wrap h1{font-size:40px;line-height:1.14;margin:0 0 20px;color:#0d1b38}.article-wrap h2{font-size:29px;margin:40px 0 14px;color:#0d1b38}.article-wrap h3{font-size:23px;margin:26px 0 10px;color:#12335f}.article-wrap p{margin:0 0 18px}.article-wrap a{color:#0f62fe;font-weight:700}.article-wrap figure{margin:28px 0}.article-wrap img{width:600px;max-width:100%;height:400px;object-fit:cover;border-radius:10px;display:block;margin-left:auto;margin-right:auto;background:#f3f6fb}.article-wrap figcaption{font-size:14px;color:#5f6b7a;margin-top:8px;text-align:center}.article-wrap table{width:100%;border-collapse:collapse;margin:24px 0;font-size:16px}.article-wrap th,.article-wrap td{border:1px solid #d9e2ef;padding:12px;vertical-align:top}.article-wrap th{background:#0d1b38;color:#fff;text-align:left}.article-wrap ul{padding-left:24px;margin:16px 0 24px}.article-wrap li{margin-bottom:10px}.cta-panel{background:#eef5ff;border-left:5px solid #0f62fe;padding:20px;margin:28px 0;border-radius:8px}.sales-box{background:#f8fafc;border:1px solid #d9e2ef;padding:18px;border-radius:8px;margin:22px 0}.intent-box{background:#fffdf5;border:1px solid #eadca7;padding:18px;border-radius:8px;margin:22px 0}</style>'
  $parts = New-Object System.Collections.Generic.List[string]
  $parts.Add($css)
  $parts.Add('<article class="article-wrap">')
  $parts.Add("<h1>$($post.Title)</h1>")
  $parts.Add((Para "$kw matters because Starlink users in Kenya need more than fast speeds; they need a dependable way to manage service, solve account issues, check payments, ask installation questions, and recover quickly when something stops working. A good support path protects daily calls, payment systems, school work, guest access, and business operations. The right plan starts with clear records, verified account details, the person responsible for the service, and the support route that will still be useful after the first setup day."))
  $parts.Add((Para "For many Kenyan customers, $kw is part of a bigger decision about satellite internet, local Wi-Fi coverage, monthly plans, and after-sale help. Before making changes, compare $($links.install), $($links.price), $($links.packages), and $($links.internet) so the account, subscription, installation, and support expectations are clear. This is especially important where fibre is weak, mobile data is expensive, or work depends on stable video meetings, uploads, bookings, and online payments."))
  $parts.Add((Para "This guide explains $kw from the practical side: what to prepare, which questions to ask, what records to keep, and how to judge whether support advice is reliable. It is written for $($post.Scenario), with enough implementation depth to help a customer avoid vague answers and repeated explanations. The goal is simple: $($post.Benefit), clear ownership, and a support process that can be followed by anyone responsible for the connection."))
  $parts.Add((Figure $post.Images[0] $kw "$kw begins with account clarity, service records, and a reliable support plan."))

  $sections = @(
    @{H="Search intent dominance layer for $kw"; P1="$kw usually means the reader wants a practical answer, not a thin sales page. Some people need a contact route, others need login help, payment guidance, activation support, package clarification, or a second opinion after confusing advice. A strong page answers every stage of that search journey with direct language, local examples, and realistic next steps."; P2="The best answer separates urgent support intent from research intent. A researcher needs plain explanations about accounts, plans, installation, router coverage, service status, and payment records. A ready customer needs response timing, required details, escalation options, and clear next action. That is why a provider should ask about account ownership, location, equipment status, current error, and the main service problem before offering advice."},
    @{H="$kw implementation depth"; P1="Implementation depth is where many weak support offers fall apart. $kw should include account checks, service-plan notes, payment review, app access, router status, installation history, and a handover record that the customer can understand. If a provider cannot explain those steps, the user may repeat the same problem to different people without getting closer to a fix."; P2="A practical support process also considers power stability, indoor Wi-Fi, device access, password records, payment method, service address, and the person authorized to make account changes. These details are not decoration. They decide whether the customer gets a useful answer or spends the week guessing why the connection, app, or subscription is not behaving as expected."},
    @{H="Strong E-E-A-T signals for Starlink users"; P1="Experience shows in the questions asked before support advice is given. A serious provider asks about the account, service status, installation date, router lights, app messages, payment history, and recent changes at the site. Expertise shows in how clearly those answers are explained. Authoritativeness comes from consistent guidance across $($links.kenya), installation pages, package pages, and support content."; P2="Trust is built when the provider does not hide limits. Starlink can perform very well, but the account must be managed properly, the app needs correct access, the router needs good placement, and large buildings may need extra Wi-Fi planning. Honest explanations about these limits protect the customer and make $kw more dependable in real use."},
    @{H="$kw comparison dominance section"; P1="A good comparison does not reward the loudest promise automatically. It compares response clarity, account guidance, installation knowledge, payment understanding, router troubleshooting, escalation discipline, and after-sale availability. Fast words can become costly if nobody records the issue, checks the account properly, or follows up when the first answer does not work."; P2="Customers should compare local options with context. Useful market references include $($links.starlite), $($links.installers), $($links.amazon), $($links.space), and $($links.orbit). These external comparisons help users understand how different providers present installation, satellite internet, support, and related services, while internal pages keep the decision grounded in OrbitInternet Kenya's Starlink guidance."},
    @{H="Objection handling section"; P1="The first objection is trust. The right answer is not to demand blind confidence, but to explain what details are needed, what can be checked, and what action will follow. The second objection is cost. That is handled by separating free guidance, paid installation work, accessories, account help, and follow-up support. The third objection is time, which requires clear priorities and realistic response expectations."; P2="Some customers worry that Starlink accounts and apps will be too technical. That concern is fair. $kw should reduce complexity by giving the customer plain notes, app guidance, Wi-Fi names, password records, account reminders, and support contacts. The user should not be left guessing how to restart equipment, check service status, or request help later."},
    @{H="Decision CTA architecture"; P1="If you are still comparing, start with $($links.price), $($links.packages), and $($links.internet). If your question is about the physical work, read $($links.install) and $($links.mombasa). If you also track new satellite internet options, compare $($links.leo) and $($links.kuiper). Then prepare your location, account issue, device status, user count, and deadline before requesting support."; P2="The strongest call to action is specific. Ask for help that separates account access, payment checks, installation work, router troubleshooting, and support follow-up. Ask what details are needed before the first response. Ask who handles escalation. This approach turns $kw into a support process with evidence, not pressure."}
  )

  for ($i = 0; $i -lt $sections.Count; $i++) {
    $s = $sections[$i]
    $parts.Add("<h2>$($s.H)</h2>")
    $parts.Add((Para $s.P1))
    $parts.Add((Para $s.P2))
    if ($i -lt 5) { $parts.Add((Figure $post.Images[$i + 1] "Starlink Kenya setup example $($i + 1)" "A good Starlink plan should match the real site, not a generic promise.")) }
  }

  $parts.Add("<h2>$kw comparison table</h2>")
  $parts.Add('<table><thead><tr><th>Decision area</th><th>Weak approach</th><th>Better approach</th></tr></thead><tbody>')
  $rows = @(
    @("Account access","Customer is told to try again without checking the account details.","Provider asks for the exact error, device, service status, and account ownership context."),
    @("Contact route","Every issue is pushed through the same vague number or chat.","Sales, installation, account, and troubleshooting questions are separated clearly."),
    @("Payment checks","Subscription questions are answered with guesses.","Plan, billing date, payment method, and service status are reviewed before advice is given."),
    @("Wi-Fi coverage","Slow speed is blamed on Starlink without testing indoors.","Router location, walls, rooms, extenders, and speed tests are checked."),
    @("Follow-up","The customer repeats the same story every time.","Support route, response expectation, handover notes, and escalation path are shared.")
  )
  foreach ($r in $rows) { $parts.Add("<tr><td>$($r[0])</td><td>$($r[1])</td><td>$($r[2])</td></tr>") }
  $parts.Add('</tbody></table>')

  $parts.Add("<h3>$kw buyer checklist</h3>")
  $parts.Add('<ul>')
  $checkItems = @(
    "Confirm who owns the account and who is allowed to request service changes.",
    "Keep payment details, service plan notes, and recent app messages ready before asking for help.",
    "Describe the exact issue instead of saying the internet is down or the app is not working.",
    "Confirm whether the problem is account access, payment, router coverage, installation, or service status.",
    "Request clear support contacts, handover notes, and follow-up expectations before closing the issue."
  )
  foreach ($item in $checkItems) { $parts.Add("<li>$item</li>") }
  $parts.Add('</ul>')

  $extra = @(
    @{H="Budget planning and support clarity"; P="$kw should be handled with enough detail to compare help fairly. A customer should know what belongs to free guidance, what belongs to installation work, what belongs to accessories, and what belongs to paid support. Router checks, account guidance, return visits, mesh Wi-Fi, cable protection, and relocation help should not appear later as surprises. Clear scope makes the decision calmer and reduces disputes after support begins."},
    @{H="Local network checks after Starlink"; P="Many complaints blamed on satellite internet are actually indoor network problems. Thick walls, long corridors, metal roofing, hidden routers, and too many devices on one access point can reduce the experience. A practical support process tests speed near the router and in important rooms. If the building needs extra access points, that should be explained early so expectations remain realistic."},
    @{H="Support questions before payment"; P="Ask whether the provider has handled similar account or support issues, what details are needed, how installation history will be checked, and whether after-sale help is available. Ask for the exact deliverables in writing. Ask whether the service address, account access, and payment method are ready. These questions protect homes and businesses from rushed decisions."},
    @{H="Semantic keyword expansion"; P="Related terms include Starlink Kenya support, Starlink customer care Kenya, Starlink app login Kenya, Starlink account help Kenya, Starlink payment Kenya, Starlink troubleshooting Kenya, Starlink installer Kenya, satellite internet Kenya, Starlink packages Kenya, Starlink router coverage, and Starlink service Kenya. These phrases reflect the real user journey around $kw and help the article answer related questions naturally."},
    @{H="Risk controls for homes and businesses"; P="A home user may care most about streaming, school work, and video calls. A business may care about uptime, payment terminals, guest Wi-Fi, CCTV, bookings, and staff devices. Both need a support route. For higher-risk sites, the customer should document router settings, account ownership, service plan, equipment location, and support numbers so future troubleshooting is faster."},
    @{H="When guided support is worth it"; P="Guided support is useful when the account has unclear ownership, the app is confusing, payment status is uncertain, the building has many users, or the connection supports important work. It is also useful when the buyer is unsure about activation, monthly plan choices, router coverage, or relocation. The value is not only advice; it is the reduced chance of a slow, confusing fix."}
  )
  foreach ($x in $extra) {
    $parts.Add("<h2>$($x.H)</h2>")
    $parts.Add((Para $x.P))
    $parts.Add((Para "For this reason, the Starlink project should be judged by outcome, not by a single line item. The better provider explains trade-offs, records the work, tests the connection, and leaves the customer with a support path. That discipline is what turns Starlink from a promising kit into dependable internet."))
  }

  $parts.Add("<div class=""intent-box""><h2>Search intent dominance layer summary</h2>")
  $parts.Add((Para "People searching for $kw normally want speed, clarity, account confidence, and local support. This article serves informational, commercial, and transactional intent by explaining what to check, how to compare providers, what questions to ask, and when to request direct help. That structure helps readers move from research to action without forcing a rushed decision."))
  $parts.Add("</div>")

  $parts.Add("<div class=""sales-box""><h2>Broad decision CTA architecture</h2>")
  $parts.Add((Para "The best next step is to share your location, account issue, device status, number of users, main rooms, recent app message, and current internet problem. With that information, a provider can recommend whether you need account guidance, payment checks, activation help, router troubleshooting, mesh Wi-Fi, or ongoing support. $kw becomes much easier when the first conversation is specific."))
  $parts.Add("</div>")

  $parts.Add("<h2>FAQs about $kw</h2>")
  $faqs = @(
    @{Q="How do I start $kw safely?"; A="Start by confirming who owns the account, what issue is happening, and what changed recently. Keep your service plan details, app message, payment status, location, router status, and installation history ready. A provider should explain what can be checked first, what details are sensitive, and what action should follow before asking you to approve paid help."},
    @{Q="What details should I prepare before asking for help?"; A="Prepare the account email or owner name where appropriate, the service location, the Starlink kit status, recent payment information, router light behavior, app screenshots, and the rooms affected by the issue. Do not share passwords casually. Good support should work from clear symptoms, records, and authorized account access instead of guesswork."},
    @{Q="Can local support help with login or account problems?"; A="Local support can often help you understand the process, prepare the right details, check equipment behavior, and separate account issues from router or installation problems. Some account changes may still need the official Starlink app or account owner action. The useful local role is to reduce confusion and help you take the correct next step."},
    @{Q="Why do Starlink support answers differ so much?"; A="Answers differ because problems differ. A login issue is not the same as a payment issue, a weak Wi-Fi signal, an obstruction warning, or an inactive service plan. Compare whether the provider asks enough questions before giving advice. A fast answer is not always better if it skips account ownership, service status, or site conditions."},
    @{Q="What is the best next step after reading this guide?"; A="Write down the exact issue, your location, device used, account status, recent payments, router behavior, and any app message. Then request help that separates account access, payment review, installation checks, router coverage, and follow-up support. That gives you a practical way to compare advice and move forward with fewer surprises."}
  )
  foreach ($f in $faqs) {
    $parts.Add("<h3>$($f.Q)</h3>")
    $parts.Add((Para $f.A))
  }

  $parts.Add("<h2>Final thoughts on $kw</h2>")
  $parts.Add((Para "$kw is a practical service decision, not a slogan. The customer needs a complete path from account clarity to login access, payment review, installation context, Wi-Fi testing, troubleshooting, and long-term support. The best result comes from asking direct questions before sharing sensitive details and checking whether the provider can explain the process in plain terms. A clear support path protects time, money, and the daily routines that depend on internet access."))
  $parts.Add((Para "Internal research also helps. Read $($links.install), $($links.price), $($links.packages), $($links.internet), and $($links.kenya) to compare installation, price, packages, and general Starlink guidance. For wider satellite internet context, review $($links.leo) and $($links.kuiper). These pages give a customer more than one angle before choosing the right support route."))
  $parts.Add((Para "The final test is simple: can the provider explain what will happen before, during, and after support? If the answer is clear, documented, and locally relevant, $kw becomes a manageable process instead of a gamble. For homes and businesses that depend on steady internet, that clarity is worth insisting on from the first conversation."))
  $parts.Add('</article>')

  $html = ($parts -join "`n")
  while ((Count-Words $html) -lt 2550) {
    $parts.Insert(($parts.Count - 1), (Para "A final practical note is to keep records. Save payment details, account notes, Wi-Fi names, router location, installation photos, and support contacts. If the connection slows, the site changes, or the customer relocates equipment, those records make troubleshooting faster and prevent repeated explanations. Good documentation is a small habit that protects the whole setup."))
    $html = ($parts -join "`n")
  }
  return $html
}

if ($DryRun) {
  $dryResults = New-Object System.Collections.Generic.List[object]
  foreach ($post in $posts) {
    $articleHtml = Build-Article $post
    $words = Count-Words $articleHtml
    $phraseCount = Count-Phrase $articleHtml $post.Keyword
    $density = [math]::Round(($phraseCount / [double]$words) * 100, 2)
    $dryResults.Add([pscustomobject]@{
      Keyword = $post.Keyword
      Title = $post.Title
      Words = $words
      KeywordMentions = $phraseCount
      PhraseDensityPercent = $density
      Images = ([regex]::Matches($articleHtml, '<img\b')).Count
      H2 = ([regex]::Matches($articleHtml, '<h2\b')).Count
      H3 = ([regex]::Matches($articleHtml, '<h3\b')).Count
    })
  }
  $dryResults | Format-Table -AutoSize | Out-String | Write-Host
  exit 0
}

$cookieContainer = New-Object System.Net.CookieContainer
$handler = New-Object System.Net.Http.HttpClientHandler
$handler.CookieContainer = $cookieContainer
$handler.AllowAutoRedirect = $true
$client = New-Object System.Net.Http.HttpClient($handler)
$client.Timeout = [TimeSpan]::FromMinutes(5)
$client.DefaultRequestHeaders.UserAgent.ParseAdd("Mozilla/5.0 OrbitPublisher/1.0")

$loginHtml = $client.GetStringAsync("$base/login.php").GetAwaiter().GetResult()
$loginToken = Get-Token $loginHtml
$loginPairs = New-Object "System.Collections.Generic.List[System.Collections.Generic.KeyValuePair[string,string]]"
$loginPairs.Add([System.Collections.Generic.KeyValuePair[string,string]]::new("_token", $loginToken))
$loginPairs.Add([System.Collections.Generic.KeyValuePair[string,string]]::new("email", $email))
$loginPairs.Add([System.Collections.Generic.KeyValuePair[string,string]]::new("password", $password))
$loginBody = [System.Net.Http.FormUrlEncodedContent]::new($loginPairs)
$loginResponse = $client.PostAsync("$base/login", $loginBody).GetAwaiter().GetResult()
$loginText = $loginResponse.Content.ReadAsStringAsync().GetAwaiter().GetResult()
if ($loginText -notmatch "pages|new-post|Dashboard|logout") { throw "Login did not reach the admin panel." }

$tmp = Join-Path (Get-Location) "orbit-publish-images"
New-Item -ItemType Directory -Force -Path $tmp | Out-Null

$results = New-Object System.Collections.Generic.List[object]
for ($i = 0; $i -lt $posts.Count; $i++) {
  $post = $posts[$i]
  $articleHtml = Build-Article $post
  $words = Count-Words $articleHtml
  $phraseCount = Count-Phrase $articleHtml $post.Keyword
  $density = [math]::Round(($phraseCount / [double]$words) * 100, 2)

  if ($words -lt 2500) { throw "$($post.Title) is below 2500 words: $words" }
  if ($phraseCount -lt 10) { throw "$($post.Title) has too few keyword mentions: $phraseCount" }

  $pagesBefore = $client.GetStringAsync("$base/pages").GetAwaiter().GetResult()
  $existing = Find-ExistingPost $pagesBefore $post.Title
  $submitUrl = "$base/save-page"
  if ($null -ne $existing) {
    $editHtml = $client.GetStringAsync("$base/pages/$($existing.Id)/edit").GetAwaiter().GetResult()
    $token = Get-Token $editHtml
    $submitUrl = "$base/update-page/$($existing.Id)"
  }
  else {
    $newHtml = $client.GetStringAsync("$base/new-post").GetAwaiter().GetResult()
    $token = Get-Token $newHtml
  }

  $heroExt = ".jpg"
  if ($post.Hero -match "\.webp($|\?)") { $heroExt = ".webp" }
  if ($post.Hero -match "\.png($|\?)") { $heroExt = ".png" }
  $heroPath = Join-Path $tmp ("hero-{0}{1}" -f $i, $heroExt)
  if ($null -eq $existing) {
    [System.IO.File]::WriteAllBytes($heroPath, $client.GetByteArrayAsync($post.Hero).GetAwaiter().GetResult())
  }

  $mp = New-Object System.Net.Http.MultipartFormDataContent
  $mp.Add((New-Object System.Net.Http.StringContent($token)), "_token")
  $mp.Add((New-Object System.Net.Http.StringContent($post.Title)), "meta_title")
  $mp.Add((New-Object System.Net.Http.StringContent($post.Meta)), "meta_description")
  $mp.Add((New-Object System.Net.Http.StringContent($post.Title)), "title")
  $mp.Add((New-Object System.Net.Http.StringContent("$($post.Keyword) clear Starlink Kenya setup guide")), "alter_text")
  $mp.Add((New-Object System.Net.Http.StringContent($post.H2)), "head_2")
  $mp.Add((New-Object System.Net.Http.StringContent("Post")), "type")
  $mp.Add((New-Object System.Net.Http.StringContent($articleHtml, [System.Text.Encoding]::UTF8, "text/html")), "description")
  $stream = $null
  if ($null -eq $existing) {
    $stream = [System.IO.File]::OpenRead($heroPath)
    $fileContent = New-Object System.Net.Http.StreamContent($stream)
    $fileContent.Headers.ContentType = [System.Net.Http.Headers.MediaTypeHeaderValue]::Parse("image/jpeg")
    $mp.Add($fileContent, "photo", [System.IO.Path]::GetFileName($heroPath))
  }

  try {
    $response = $client.PostAsync($submitUrl, $mp).GetAwaiter().GetResult()
    $responseText = $response.Content.ReadAsStringAsync().GetAwaiter().GetResult()
    if (-not $response.IsSuccessStatusCode) { throw "HTTP $([int]$response.StatusCode) $responseText" }
  }
  finally {
    if ($null -ne $stream) { $stream.Dispose() }
    $mp.Dispose()
  }

  $pagesHtml = $client.GetStringAsync("$base/pages").GetAwaiter().GetResult()
  $titleEsc = [regex]::Escape($post.Title)
  $url = $null
  $m = [regex]::Match($pagesHtml, '<a href="([^"]+)" target="_blank" class="btn btn-outline-info btn-sm">\s*<i[^>]*></i>\s*View\s*</a>.*?<a href="([^"]+/pages/(\d+)/edit)"', [System.Text.RegularExpressions.RegexOptions]::Singleline)
  $titleMatch = [regex]::Match($pagesHtml, $titleEsc)
  if ($titleMatch.Success) {
    $before = $pagesHtml.Substring([Math]::Max(0, $titleMatch.Index - 900), [Math]::Min(1800, $pagesHtml.Length - [Math]::Max(0, $titleMatch.Index - 900)))
    $vm = [regex]::Match($before, '<a href="([^"]+)" target="_blank" class="btn btn-outline-info btn-sm">')
    if ($vm.Success) { $url = $vm.Groups[1].Value }
  }
  if (-not $url -and $m.Success) { $url = $m.Groups[1].Value }

  $results.Add([pscustomobject]@{
    Keyword = $post.Keyword
    Title = $post.Title
    Words = $words
    KeywordMentions = $phraseCount
    PhraseDensityPercent = $density
    Url = $url
  })
  $action = if ($null -ne $existing) { "UPDATED" } else { "POSTED" }
  Write-Host ("{0}: {1} words={2} mentions={3} density={4}% url={5}" -f $action,$post.Title,$words,$phraseCount,$density,$url)
}

$results | Format-Table -AutoSize | Out-String | Write-Host
