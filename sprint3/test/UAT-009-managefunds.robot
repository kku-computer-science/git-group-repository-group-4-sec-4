*** Settings ***   
Library          SeleniumLibrary
Test Teardown    Close Browser

*** Variables ***
${BROWSER}           chrome
${HOME_URL}          https://cs0404.cpkkuhost.com/login
${WAIT_TIME}         3s
${WEBDRIVER_PATH}    /Users/ptpspp/Documents/GitHub/git-group-repository-group-4-sec-4/test/test_sprint3/chromedriver-mac-arm64/chromedriver

# ฟิลด์สำหรับล็อกอิน
${USER}             admin@gmail.com
${PASSWORD}         12345678
${USER_FIELD}       id=username
${PASSWORD_FIELD}   id=password
${LOGIN_BUTTON}     xpath=//button[@type='submit']

# เมนู Dashboard
${DASHBOARD_MENU}   xpath=//a[contains(@href, '/funds')]

# เปลี่ยนภาษา (ตัวเลือกใน dropdown)
${LANG_DROPDOWN_TOGGLE}    xpath=//a[@id="languageDropdown"]
${LANG_TO_THAI}       xpath=//div[contains(@class, 'dropdown-menu')]//a[contains(@href, '/lang/th')]
${LANG_TO_CHINESE}    xpath=//div[contains(@class, 'dropdown-menu')]//a[contains(@href, '/lang/zh')]

# ตรวจสอบข้อความที่ต้องปรากฏหลังจากเปลี่ยนภาษา
${WELCOME_TEXT_TH}    ยินดีต้อนรับเข้าสู่ระบบจัดการข้อมูลวิจัยของสาขาวิชาวิทยาการคอมพิวเตอร์
@{TEXT_TH}    
...    ทุนวิจัย 
...    ลำดับ    
...    ชื่อทุน
...    ประเภททุน
...    ระดับทุน
...    การดำเนินการ

@{TEXT_ENG}    
...    Research Funding
...    No.    
...    Fund name
...    Fund Type
...    Fund Level
...    Action
...    Internal S

@{TEXT_ZH}    
...    研究资金
...    编号    
...    基金名称
...    基金类型
...    基金级别
...    操作
...    内部奖学金

#หน้าที่ test
${URL_FOR_TEST}    https://cs0404.cpkkuhost.com/funds  

*** Keywords ***
Open Browser To Home Page
    Open Browser    ${HOME_URL}    ${BROWSER}    executable_path=${WEBDRIVER_PATH}
    Maximize Browser Window

Login As Admin
    Input Text    ${USER_FIELD}    ${USER}
    Input Text    ${PASSWORD_FIELD}    ${PASSWORD}
    Click Button  ${LOGIN_BUTTON}
    Wait Until Element Is Visible  ${DASHBOARD_MENU}  timeout=5s
    Go To    ${URL_FOR_TEST} 
    Log  "Login Successful, Dashboard loaded."

Change Language To Thai
    Click Element    ${LANG_DROPDOWN_TOGGLE}
    Sleep    2s
    Wait Until Element Is Enabled    ${LANG_TO_THAI}    timeout=10s
    Click Element    ${LANG_TO_THAI}
    ${PAGE_TEXT}    Get Text    xpath=//body
    # ตรวจสอบข้อความภาษาไทย
    FOR    ${TEXT}    IN    @{TEXT_TH}
        Should Contain    ${PAGE_TEXT}    ${TEXT}
    END
    Log  "Language changed to Thai successfully."    INFO
    Log To Console  "Language changed to Thai successfully."  # แสดงผลบน Console


Change Language To English
    Click Element    ${LANG_DROPDOWN_TOGGLE}
    Sleep    2s
    ${PAGE_TEXT}    Get Text    xpath=//body
    # ตรวจสอบข้อความภาษาไทย
    FOR    ${TEXT}    IN    @{TEXT_ENG}
        Should Contain    ${PAGE_TEXT}    ${TEXT}
    END
    Log  "Language changed to English successfully."

Change Language To Chinese
    Click Element    ${LANG_DROPDOWN_TOGGLE}
    Sleep    2s
    Wait Until Element Is Enabled    ${LANG_TO_CHINESE}    timeout=10s
    Click Element    ${LANG_TO_CHINESE}
    ${PAGE_TEXT}    Get Text    xpath=//body
    # ตรวจสอบข้อความภาษาไทย
    FOR    ${TEXT}    IN    @{TEXT_ZH}
        Should Contain    ${PAGE_TEXT}    ${TEXT}
    END
    Log  "Language changed to Chinese successfully."

*** Test Cases ***
Admin Login And Change Language To Thai
    Open Browser To Home Page
    Login As Admin
    Change Language To Thai
    Close Browser

Admin Login And Change Language To English
    Open Browser To Home Page
    Login As Admin
    Change Language To English
    Close Browser

Admin Login And Change Language To Chinese
    Open Browser To Home Page
    Login As Admin
    Change Language To Chinese
    Close Browser
