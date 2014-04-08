# Display Stage
STAGES = []
STAGES[0x00] = [$('#login'), $('#login_form')]
STAGES[0x01] = [$('#login'), $('#register_form')]
STAGES[0x02] = [$('#game'), $('#lobby')]
STAGES[0x03] = [$('#game'), $('#table')]

# Cue rows
CUE_ROWS = []
CUE_ROWS[0x00] = $('#first_line')
CUE_ROWS[0x01] = $('#second_line')

# Tile Colors
COLORS = []
COLORS[0x00] = 'black'
COLORS[0x01] = 'blue'
COLORS[0x02] = 'red'
COLORS[0x03] = 'yellow'
COLORS[0x04] = 'fake'

# Directions
DIRECTIONS = []
DIRECTIONS[0x00] = 's'
DIRECTIONS[0x01] = 'e'
DIRECTIONS[0x02] = 'n'
DIRECTIONS[0x03] = 'w'

# Discarded Tile Holders
DISCARDS = []
DISCARDS[0x00] = $('#discard_se')
DISCARDS[0x01] = $('#discard_ne')
DISCARDS[0x02] = $('#discard_nw')
DISCARDS[0x03] = $('#discard_sw')

# Players
PLAYERS = []
PLAYERS[0x00] = $('#player_s')
PLAYERS[0x01] = $('#player_e')
PLAYERS[0x02] = $('#player_n')
PLAYERS[0x03] = $('#player_w')